<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Registration and Login</title>
  <style>
    /* Reset & base */
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 40px 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #d4f1f9, #ffffff);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      color: #333;
    }

    /* Header */
    .header {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 30px;
    }
    .circle {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      background: linear-gradient(135deg, #2bbbad, #1e8a8a);
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      margin-bottom: 15px;
      transition: transform 0.3s ease;
    }
    .circle:hover {
      transform: scale(1.05);
    }
    .title {
      font-size: 28px;
      font-weight: 700;
      color: #1e3d59;
      letter-spacing: 1.2px;
      text-align: center;
      text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Layout Grid */
    .flexbox {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-areas:
        "box1 box3"
        "box2 box3";
      gap: 25px;
      max-width: 1050px;
      width: 100%;
      border-radius: 20px;
      border: 2px dotted #6c757d;
      padding: 20px;
      background: #fff;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    /* Boxes */
    .box {
      background: white;
      border-radius: 15px;
      padding: 30px 35px;
      box-shadow: 0 8px 18px rgba(0,0,0,0.07);
      display: flex;
      flex-direction: column;
      box-sizing: border-box;
    }
    .box1 { grid-area: box1; background: #e0f7fa; }
    .box2 { grid-area: box2; background: #e3f2fd; }
    .box3 { 
      grid-area: box3;
      background: #e8f5e9;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 25px;
      box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    }

    /* Form Titles */
    .box h1 {
      margin-bottom: 25px;
      font-weight: 700;
      font-size: 26px;
      color: #0d47a1;
      text-align: center;
      letter-spacing: 0.03em;
    }

    /* Form Styling */
    .form-container {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }
    label {
      font-weight: 600;
      font-size: 14px;
      color: #333;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    select,
    input[type="color"] {
      padding: 10px 14px;
      font-size: 15px;
      border: 1.8px solid #9e9e9e;
      border-radius: 8px;
      transition: border-color 0.25s ease, box-shadow 0.25s ease;
      outline-offset: 2px;
      outline-color: transparent;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="date"]:focus,
    select:focus,
    input[type="color"]:focus {
      border-color: #0288d1;
      box-shadow: 0 0 8px #0288d1aa;
      outline-color: #0288d1;
    }
    input[type="color"] {
      padding: 0;
      height: 40px;
      cursor: pointer;
    }

    /* Checkbox */
    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
      color: #444;
      user-select: none;
    }
    .checkbox-container input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    /* Buttons */
    .submit-btn {
      margin-top: 15px;
      background: linear-gradient(135deg, #00897b, #004d40);
      border: none;
      color: white;
      font-size: 17px;
      font-weight: 700;
      padding: 12px 0;
      border-radius: 12px;
      cursor: pointer;
      transition: background 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 77, 64, 0.3);
    }
    .submit-btn:hover {
      background: linear-gradient(135deg, #004d40, #00695c);
      box-shadow: 0 8px 25px rgba(0, 77, 64, 0.5);
    }

    /* Table Styling */
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border-radius: 12px;
      overflow: hidden;
      background: white;
    }
    th, td {
      padding: 12px 18px;
      text-align: center;
      border-bottom: 1px solid #ddd;
      color: #37474f;
    }
    th {
      background: #b2dfdb;
      font-weight: 700;
      letter-spacing: 0.05em;
    }
    tbody tr:nth-child(odd) {
      background: #e0f2f1;
    }
    tbody tr:hover {
      background: #a7ffeb;
      transition: background-color 0.3s ease;
    }

    /* Responsive tweak */
    @media (max-width: 1100px) {
      .flexbox {
        grid-template-columns: 1fr;
        grid-template-areas:
          "box1"
          "box2"
          "box3";
        gap: 25px;
      }
      .box {
        padding: 25px;
      }
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
          <label for="fullName">Full Name:</label>
          <input type="text" id="fullName" name="fullName" required />
          
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />
          
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
          
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required />
          
          <label for="dob">Date of Birth:</label>
          <input type="date" id="dob" name="dob" required />
          
          <label for="country">Country:</label>
          <select id="country" name="country" required>
            <option value="">Select Country</option>
            <option value="bd">Bangladesh</option>
            <option value="usa">USA</option>
            <option value="uk">UK</option>
            <option value="gr">Germany</option>
            <option value="au">Australia</option>
          </select>
          
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="prefer-not">Prefer not to say</option>
          </select>
          
          <label for="colorPreference">Color Preference:</label>
          <input type="color" id="colorPreference" name="colorPreference" value="#ff0000" />
          
          <div class="checkbox-container">
            <input type="checkbox" id="terms" name="terms" required />
            <label for="terms">I agree to the Terms and Conditions</label>
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
          <label for="loginEmail">Email:</label>
          <input type="email" id="loginEmail" name="loginEmail" required />
          
          <label for="loginPassword">Password:</label>
          <input type="password" id="loginPassword" name="loginPassword" required />
          
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
