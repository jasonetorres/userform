<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Info Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    label {
      display: block;
      margin-bottom: 8px;
      color: #555;
    }
    input[type="text"],
    input[type="email"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      border: none;
      border-radius: 4px;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Enter Your Information</h1>
    <form id="userForm">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

        fetch('/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ name, email })
        })
        .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
            throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
            });
        }
        return response.json();
        })
        .then(data => {
        if (data.success) {
            alert('Information submitted successfully!');
        } else {
            alert('There was an error submitting your information.');
        }
        })
        .catch(e => {
        console.error('There was a problem with the fetch operation:', e);
        alert('An error occurred. Please try again later.');
        });
    </script>
</body>
</html>
