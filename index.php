<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }
        
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
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
            grid-template-columns: 400px 400px;
            grid-template-areas: 
                "box1 box3"
                "box2 box3";
            gap: 0; /* Remove the gap between the boxes */
            width: 800px;
            border-radius: 15px; /* Rounded outer corners for the entire layout */
            overflow: hidden; /* Ensure content doesn't overflow */
        }
        
        .box {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .box1 {
            grid-area: box1;
            background-color: aqua;
            height: auto;
            width: 400px;
            border-radius: 15px; /* Rounded outer corners for Box 1 */
        }
        
        .box2 {
            grid-area: box2;
            background-color: skyblue;
            height: 150px;
            width: 400px;
            border-radius: 15px; /* Rounded outer corners for Box 2 */
        }
        
        .box3 {
            grid-area: box3;
            background-color: lightgreen;
            height: 100%;
            width: 400px;
            border-radius: 15px; /* Rounded outer corners for Box 3 */
        }
        
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            justify-content: flex-start;
            align-items: center;
            padding: 15px;
            border-radius: 15px; /* Rounded outer corners for the form */
            background-color: #ffffff;
        }
        
        .form-container label {
            margin-bottom: 3px;
            font-size: 15px;
            display: block;
            width: 320px; 
        }
        
        .form-container input,
        .form-container select {
            padding: 8px;
            width: 320px;
            box-sizing: border-box;
            font-size: 14px;
            margin: 0;
            border-radius: 5px; /* Rounded corners for inputs */
        }
        
        input[type="color"] {
            padding: 0;
            height: 36px;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            width: 320px;
        }
        
        .checkbox-container input {
            width: auto;
            margin-right: 8px;
        }
        
        .submit-btn {
            margin-top: 15px;
            margin-bottom: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px; /* Rounded corners for the submit button */
            cursor: pointer;
            font-size: 16px;
            width: 320px;
        }
        
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="circle"></div>
        <div class="title">Registration Form</div>
    </div>
    
    <div class="flexbox">
        <div class="box box1">
            <form method="POST" action="process.php">
                <div class="form-container">
                    <div>
                        <label>User Full Name:</label>
                        <input type="text" name="fullName" placeholder="Enter your full name" required />
                    </div>
                    <div>
                        <label>User Email:</label>
                        <input type="email" name="email" placeholder="Enter your email" required />
                    </div>
                    <div>
                        <label>Password:</label>
                        <input type="password" name="password" placeholder="Enter your password" required />
                    </div>
                    <div>
                        <label>Confirm Password:</label>
                        <input type="password" name="confirmPassword" placeholder="Confirm your password" required />
                    </div>
                    <div>
                        <label>Date of Birth:</label>
                        <input type="date" name="dob" required />
                    </div>
                    <div>
                        <label>Country:</label>
                        <select name="country" required>
                            <option value="">Select Country</option>
                            <option value="au">Australia</option>
                            <option value="bd">Bangladesh</option>
                            <option value="gr">Germany</option>
                            <option value="uk">UK</option>
                            <option value="usa">USA</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label>Gender:</label>
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="prefer-not">Prefer not to say</option>
                        </select>
                    </div>
                    <div>
                        <label>Color Preference:</label>
                        <input type="color" name="colorPreference" value="#ff0000" />
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" id="terms" name="terms" required />
                        <label for="terms">I agree to the Terms and Conditions</label>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>
        <div class="box box2"></div>
        <div class="box box3">
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>City</th>
                        <th>AQI Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dhaka</td>
                        <td class="aqi" data-aqi="8.2">8.2</td>
                    </tr>
                    <tr>
                        <td>Chittagong</td>
                        <td class="aqi" data-aqi="6.5">6.5</td>
                    </tr>
                    <tr>
                        <td>Khulna</td>
                        <td class="aqi" data-aqi="4.3">4.3</td>
                    </tr>
                    <tr>
                        <td>Rajshahi</td>
                        <td class="aqi" data-aqi="7.6">7.6</td>
                    </tr>
                    <tr>
                        <td>Sylhet</td>
                        <td class="aqi" data-aqi="5.2">5.2</td>
                    </tr>
                    <tr>
                        <td>Barisal</td>
                        <td class="aqi" data-aqi="9.1">9.1</td>
                    </tr>
                    <tr>
                        <td>Rangpur</td>
                        <td class="aqi" data-aqi="3.8">3.8</td>
                    </tr>
                    <tr>
                        <td>Mymensingh</td>
                        <td class="aqi" data-aqi="7.2">7.2</td>
                    </tr>
                    <tr>
                        <td>Rajshahi</td>
                        <td class="aqi" data-aqi="6.8">6.8</td>
                    </tr>
                    <tr>
                        <td>Comilla</td>
                        <td class="aqi" data-aqi="5.5">5.5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.aqi').forEach(cell => {
            const aqiValue = parseFloat(cell.getAttribute('data-aqi'));
            if (aqiValue > 7.5) {
                cell.style.backgroundColor = 'red';
                cell.style.color = 'white';
            } else if (aqiValue >= 5 && aqiValue <= 7.5) {
                cell.style.backgroundColor = 'yellow';
                cell.style.color = 'black';
            } else {
                cell.style.backgroundColor = 'green';
                cell.style.color = 'white';
            }
        });
    </script>
</body>
</html>
