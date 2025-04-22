<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Striker - League Table</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: black;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: antiquewhite;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

       

        .team-cell {
            display: flex;
            align-items: center;
            text-align: left;
        }

        .team-logo {
            width: 25px;
            height: 25px;
            margin-right: 10px;
            object-fit: contain;
        }

        /* Position colors */
        .pos-1, .pos-2, .pos-3 {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        .pos-9, .pos-10 {
            background-color: #f44336; /* Red */
            color: white;
        }

        /* Form indicators */
        .form {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .form-item {
            width: 22px;
            height: 22px;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .win {
            background-color: #4CAF50;
            color: white;
        }

        .draw {
            background-color: #FFC107;
            color: black;
        }

        .loss {
            background-color: #f44336;
            color: white;
        }

        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none;
            }
            
            th, td {
                padding: 8px 5px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>
        <img src="assets/images/club/BPL.png" alt="BPL Logo" style="height: 40px; vertical-align: middle; margin-right: 10px;">
         Bangladesh Premier League
    </h1>

        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="text-align: left;">Team</th>
                    <th class="hide-on-mobile">PL</th>
                    <th>W</th>
                    <th>D</th>
                    <th>L</th>
                    <th class="hide-on-mobile">GF/GA</th>
                    <th>GD</th>
                    <th>PTS</th>
                    <th>Form</th>
                    <th class="hide-on-mobile">Next</th>
                </tr>
            </thead>
            <tbody>
                <tr class="pos-1">
                    <td>1</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/mohamedan.png" alt="Mohammedan" class="team-logo">
                            <span>Mohammedan</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>10</td>
                    <td>0</td>
                    <td>1</td>
                    <td class="hide-on-mobile">26-5</td>
                    <td>+21</td>
                    <td>30</td>
                    <td>
                        <div class="form">
                            <span class="form-item win">W</span>
                            <span class="form-item win">W</span>
                            <span class="form-item win">W</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs ABH</td>
                </tr>
                <tr class="pos-2">
                    <td>2</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/abahani.png" alt="Abahani" class="team-logo">
                            <span>Abahani Limited</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>8</td>
                    <td>2</td>
                    <td>1</td>
                    <td class="hide-on-mobile">21-3</td>
                    <td>+18</td>
                    <td>26</td>
                    <td>
                        <div class="form">
                            <span class="form-item win">W</span>
                            <span class="form-item win">W</span>
                            <span class="form-item win">W</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs MOH</td>
                </tr>
                <tr class="pos-3">
                    <td>3</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/kings.png" alt="Bashundhara Kings" class="team-logo">
                            <span>Bashundhara Kings</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>6</td>
                    <td>2</td>
                    <td>3</td>
                    <td class="hide-on-mobile">30-8</td>
                    <td>+22</td>
                    <td>20</td>
                    <td>
                        <div class="form">
                            <span class="form-item win">W</span>
                            <span class="form-item win">W</span>
                            <span class="form-item loss">L</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs POL</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/rahmatgonj.png" alt="Rahmatgonj" class="team-logo">
                            <span>Rahmatgonj MFS</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>6</td>
                    <td>0</td>
                    <td>5</td>
                    <td class="hide-on-mobile">26-17</td>
                    <td>+9</td>
                    <td>18</td>
                    <td>
                        <div class="form">
                            <span class="form-item win">W</span>
                            <span class="form-item win">W</span>
                            <span class="form-item loss">L</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs FOR</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/fortis.png" alt="Fortis" class="team-logo">
                            <span>Fortis</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>4</td>
                    <td>5</td>
                    <td>2</td>
                    <td class="hide-on-mobile">14-9</td>
                    <td>+5</td>
                    <td>17</td>
                    <td>
                        <div class="form">
                            <span class="form-item draw">D</span>
                            <span class="form-item win">W</span>
                            <span class="form-item draw">D</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs RAH</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/police.png" alt="Bangladesh Police" class="team-logo">
                            <span>Bangladesh Police</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>5</td>
                    <td>1</td>
                    <td>5</td>
                    <td class="hide-on-mobile">17-16</td>
                    <td>+1</td>
                    <td>16</td>
                    <td>
                        <div class="form">
                            <span class="form-item win">W</span>
                            <span class="form-item loss">L</span>
                            <span class="form-item win">W</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs BKD</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/brothers.png" alt="Brothers Union" class="team-logo">
                            <span>Brothers Union</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>4</td>
                    <td>3</td>
                    <td>4</td>
                    <td class="hide-on-mobile">14-11</td>
                    <td>+3</td>
                    <td>15</td>
                    <td>
                        <div class="form">
                            <span class="form-item loss">L</span>
                            <span class="form-item win">W</span>
                            <span class="form-item draw">D</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs FAK</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/fakirapool.png" alt="Fakirapool" class="team-logo">
                            <span>Fakirapool</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>3</td>
                    <td>0</td>
                    <td>8</td>
                    <td class="hide-on-mobile">11-32</td>
                    <td>-21</td>
                    <td>9</td>
                    <td>
                        <div class="form">
                            <span class="form-item loss">L</span>
                            <span class="form-item loss">L</span>
                            <span class="form-item win">W</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs BRO</td>
                </tr>
                <tr class="pos-9">
                    <td>9</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/dhaka wenders.png" alt="Dhaka Wanderers" class="team-logo">
                            <span>Dhaka Wanderers</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>1</td>
                    <td>1</td>
                    <td>9</td>
                    <td class="hide-on-mobile">6-38</td>
                    <td>-32</td>
                    <td>4</td>
                    <td>
                        <div class="form">
                            <span class="form-item loss">L</span>
                            <span class="form-item loss">L</span>
                            <span class="form-item loss">L</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs CTG</td>
                </tr>
                <tr class="pos-10">
                    <td>10</td>
                    <td>
                        <div class="team-cell">
                            <img src="assets/images/club/ctgabahani.png" alt="Chittagong Abahani" class="team-logo">
                            <span>Chittagong Abahani</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">11</td>
                    <td>0</td>
                    <td>0</td>
                    <td>11</td>
                    <td class="hide-on-mobile">5-40</td>
                    <td>-35</td>
                    <td>0</td>
                    <td>
                        <div class="form">
                            <span class="form-item loss">L</span>
                            <span class="form-item loss">L</span>
                            <span class="form-item loss">L</span>
                        </div>
                    </td>
                    <td class="hide-on-mobile">vs DHA</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>