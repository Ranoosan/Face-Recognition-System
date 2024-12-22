import cv2
import mysql.connector
import numpy as np
from datetime import datetime

# Haarcascade XML file for face detection
haar_file = 'haarcascade_frontalface_default.xml'

# MySQL Database connection
db = mysql.connector.connect(
    host="localhost",
    user="root",  # Replace with your MySQL username
    password="",  # Replace with your MySQL password
    database="attendance_system"  # Replace with your database name
)
cursor = db.cursor()

# Fetch all stored faces from the database
cursor.execute("SELECT id, name, image FROM face_data")
face_data = cursor.fetchall()

# Initialize lists to store images and labels
images, labels, names = [], [], {}
id = 0

# Load all faces from the database
for (id_db, name, image_blob) in face_data:
    # Convert the image blob back to an image
    img_array = np.asarray(bytearray(image_blob), dtype=np.uint8)
    img = cv2.imdecode(img_array, cv2.IMREAD_GRAYSCALE)

    # Append the image and label (ID) to the respective lists
    images.append(img)
    labels.append(id)
    names[id] = name
    id += 1

# Convert images and labels into numpy arrays
(images, labels) = [np.array(lis) for lis in [images, labels]]

# Initialize the face recognizer model (use LBPH for better performance)
model = cv2.face.LBPHFaceRecognizer_create()
model.train(images, labels)

# Load Haar Cascade for face detection
face_cascade = cv2.CascadeClassifier(haar_file)

# Open the webcam
webcam = cv2.VideoCapture(0)
(width, height) = (130, 100)

while True:
    # Capture frame-by-frame from the webcam
    (_, im) = webcam.read()
    gray = cv2.cvtColor(im, cv2.COLOR_BGR2GRAY)  # Convert to grayscale
    faces = face_cascade.detectMultiScale(gray, 1.3, 5)

    for (x, y, w, h) in faces:
        cv2.rectangle(im, (x, y), (x+w, y+h), (255, 255, 0), 2)
        face = gray[y:y + h, x:x + w]
        face_resize = cv2.resize(face, (width, height))

        # Predict the face using the model
        prediction = model.predict(face_resize)

        # If confidence level is below a threshold, we consider it a match
        if prediction[1] < 800:
            recognized_name = names[prediction[0]]
            confidence = prediction[1]

            # Display the name on the screen
            cv2.putText(im, f'{recognized_name} - {confidence:.0f}', (x-10, y-10),
                        cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)
            print(f'Recognized: {recognized_name} with confidence {confidence}')

            # Query the database for the recognized person's ID
            cursor.execute("SELECT id FROM tbllecture WHERE CONCAT(firstName, ' ', lastName) = %s", (recognized_name,))
            result = cursor.fetchone()

            if result:
                person_id = result[0]
                print(f'Person ID: {person_id}')
                cv2.putText(im, f'ID: {person_id}', (x-10, y-40), cv2.FONT_HERSHEY_SIMPLEX, 1, (255, 255, 255), 2)

                # Get today's date
                today_date = datetime.now().date()

                # Check if the person has already been marked as present today
                cursor.execute("SELECT * FROM attendance WHERE LID = %s AND DATE(entry_time) = %s", (person_id, today_date))
                attendance_exists = cursor.fetchone()

                if attendance_exists:
                    print(f"Attendance for {recognized_name} is already recorded today.")
                else:
                    # Insert new attendance record with current timestamp
                    cursor.execute("INSERT INTO attendance (LID, entry_time) VALUES (%s, NOW())", (person_id,))
                    db.commit()
                    print(f"Attendance recorded for {recognized_name} at {datetime.now()}")

            else:
                print("ID not found in tbllecture")
        else:
            cv2.putText(im, 'Unknown', (x-10, y-10),
                        cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 0, 255), 2)
            print('Unknown person detected.')

    # Display the video with detection
    cv2.imshow('Face Recognition', im)

    # Exit on 'Esc' key
    if cv2.waitKey(10) == 27:
        break

# Release resources
webcam.release()
cv2.destroyAllWindows()

# Close the database connection
cursor.close()
db.close()
