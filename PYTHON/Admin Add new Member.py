import cv2
import os
import mysql.connector
import numpy as np

# Haarcascade XML file
haar_file = 'haarcascade_frontalface_default.xml'

# Database connection
db = mysql.connector.connect(
    host="localhost",
    user="root",  # Replace with your MySQL username
    password="",  # Replace with your MySQL password
    database="attendance_system"  # Replace with your database name
)
cursor = db.cursor()

# Create the table if it doesn't already exist
cursor.execute("""
    CREATE TABLE IF NOT EXISTS face_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        image LONGBLOB
    )
""")
db.commit()

# Ask for the lecturer's name
sub_data = input("Enter the lecturer's name: ")

# Face detection
face_cascade = cv2.CascadeClassifier(haar_file)

webcam = cv2.VideoCapture(0)  # Open the camera

count = 1
while count < 31:  # Capture 30 images
    print(f"Capturing image {count}")
    (_, im) = webcam.read()
    gray = cv2.cvtColor(im, cv2.COLOR_BGR2GRAY)
    faces = face_cascade.detectMultiScale(gray, 1.3, 4)
    
    for (x, y, w, h) in faces:
        cv2.rectangle(im, (x, y), (x+w, y+h), (255, 0, 0), 2)
        face = gray[y:y + h, x:x + w]
        
        # Resize the face image
        face_resize = cv2.resize(face, (130, 100))

        # Convert the face image to binary format for database storage
        _, buffer = cv2.imencode('.png', face_resize)
        face_binary = buffer.tobytes()
        
        # Insert the image into the database with the lecturer's name
        cursor.execute("INSERT INTO face_data (name, image) VALUES (%s, %s)", (sub_data, face_binary))
        db.commit()

        print(f"Image {count} saved to database.")
        count += 1

    # Display the video with a rectangle around the face
    cv2.imshow('OpenCV', im)
    key = cv2.waitKey(10)
    if key == 27:  # Exit if 'Esc' is pressed
        break

# Release the webcam and close windows
webcam.release()
cv2.destroyAllWindows()

# Close the database connection
cursor.close()
db.close()
