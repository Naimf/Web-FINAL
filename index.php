<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Registration and Login</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      background-color: #f0f0f0;
    }
    .header {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 30px;
    }
    .circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: lightseagreen;
      margin-bottom: 15px;
    }
    .title {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
    }
    .flexbox {
      display: grid;
      grid-template-columns: 500px 500px;
      grid-template-areas:
        "box1 box3"
        "box2 box3";
      border-radius: 20px;
      border: 2px dotted gray;
      margin-top: 20px;
    }
    .box {
      box-sizing: border-box;
    }
    .box1, .box2 {
      padding: 20px;
    }
    .box1 {
      grid-area: box1;
      background-color: aqua;
    }
    .box2 {
      grid-area: box2;
      background-color: skyblue;
    }
    .box3 {
      grid-area: box3;
      background-color: lightgreen;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .form-container {
      display: flex;
      flex-direction: column;
      gap: 8px;
      align-items: center;
      height: 100%;
    }
    .form-container label {
      display: block;
      width: 100%;
      font-size: 14px;
      margin-bottom: 2px;
    }
    .form-container input,
    .form-container select {
      width: 100%;
      padding: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }
    input[type="color"] {
      height: 36px;
      padding: 0;
    }
    .checkbox-container {
      display: flex;
      align-items: center;
      width: 100%;
    }
    .checkbox-container input {
      width: auto;
      margin-right: 8px;
    }
    .submit-btn {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }
    .submit-btn:hover {
      background-color: #45a049;
    }
    table {
      width: 95%;
      height: 90%;
      border-collapse: collapse;
      background-color: white;
    }
    th, td {
      border: 1px solid #444;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #ddd;
    }
    h1 {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="circle"></div>
    <div class="title">Registration Form</div>
  </div>

  <div class="flexbox">
    <!-- Registration Box -->
    <div class="box box1">
      <h1>Registration Form</h1>
      <form action="process.php" method="POST">
        <input type="hidden" name="formType" value="register" />
        <div class="form-container">
          <label>Full Name:</label>
          <input type="text" name="fullName" required />
          <label>Email:</label>
          <input type="email" name="email" required />
          <label>Password:</label>
          <input type="password" name="password" required />
          <label>Confirm Password:</label>
          <input type="password" name="confirmPassword" required />
          <label>Date of Birth:</label>
          <input type="date" name="dob" required />
          <label>Country:</label>
          <select name="country" required>
            <option value="">Select Country</option>
            <option value="bd">Bangladesh</option>
            <option value="usa">USA</option>
            <option value="uk">UK</option>
            <option value="gr">Germany</option>
            <option value="au">Australia</option>
          </select>
          <label>Gender:</label>
          <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="prefer-not">Prefer not to say</option>
          </select>
          <label>Color Preference:</label>
          <input type="color" name="colorPreference" value="#ff0000" />
          <div class="checkbox-container">
            <input type="checkbox" name="terms" required />
            <label>I agree to the Terms and Conditions</label>
          </div>
          <button type="submit" class="submit-btn">Register</button>
        </div>
      </form>
    </div>

    <!-- Login Box -->
    <div class="box box2">
      <h1>Login Form</h1>
      <form action="process.php" method="POST">
        <input type="hidden" name="formType" value="login" />
        <div class="form-container">
          <label>Email:</label>
          <input type="email" name="loginEmail" required />
          <label>Password:</label>
          <input type="password" name="loginPassword" required />
          <button type="submit" class="submit-btn">Login</button>
        </div>
      </form>
    </div>

    <!-- AQI Table Box -->
    <div class="box box3">
      <table>
        <thead>
          <tr><th>City</th><th>AQI Value</th></tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < 10; $i++): ?>
            <tr><td></td><td></td></tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
