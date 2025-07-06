<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Responsive About Us Page </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            background-color: black;
        }

        #aboutUs {
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        #aboutUs img {
            width: 600px;
            margin-left: 40px;
            margin-top: 50px;
            height: 600px;
            border-radius: 1000px;
        }

        .content {
            margin: 20px 0;
        }

        .content h2 {
            font-size: 50px;
            color: #ffca70;
        }

        .content h4 {
            font-size: 20px;
            color: #fff;
            margin: 10px 0;
        }

        .description {
            color: #fff;
            margin: 20px 0;
            font-size: 18px;
            line-height: 30px;
            font-weight: 100;
        }

        .btn {
            font-weight: bold;
            border: 2px solid #ffca70;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 20px;
            transition: all 0.4s;
            background-color: #ffca70;
        }

        .btn:hover {
            border: 2px solid #ffca70;
            background: transparent;
            color: #ffca70;
        }
         h1{
            color:blueviolet;
            font-size: 72px;
            padding-top:100px ;
            padding-bottom: 100px;
         }
        @media screen and (max-width: 790px) {
            #aboutUs img {
                width: 80%;
            }

            #aboutUs {
                grid-template-columns: 1fr;
                place-items: center;
            }
        }
    </style>
</head>

<body>
<center><h1>About Us</h1></center>
    <section id="aboutUs">
    
        <img src="images/js/himanshu.webp" alt="computer user">
        
        <div class="content">            
            <h2> Developer & Designer </h2>
            <p class="description">
                About Me - Himanshu Kawale, Aspiring Full Stack Developer<br>

Greetings! I'm Himanshu Kawale, on a journey to become a versatile Full Stack Developer. I thrive on translating innovative ideas into robust, end-to-end web solutions. Here's a glimpse into my journey:

My Expertise:

Front-End Wizardry: As a front-end web developer, I specialize in creating visually appealing and user-friendly interfaces. My love for clean code ensures seamless functionality.

Back-End Mastery (In Progress): Eagerly delving into the world of back-end development, I am mastering server-side technologies, databases, and server management to bring life to web applications.

Full Stack Aspirations: Bridging the gap between front-end and back-end development, I am determined to become a Full Stack Developer capable of handling every aspect of web development.
Future Goals:

My journey doesn't stop here. I am driven to continually enhance my skills, becoming a Full Stack Developer capable of transforming ambitious ideas into functional, dynamic, and scalable web applications.
            </p>
            <button class="btn">Contact</button>
        </div>
    </section>
    <section id="aboutUs">
        <img src="images/js/vaishu1.webp" alt="Vaishnavi">
        <div class="content">
       
            <h2> Developer & Designer </h2>
            <p class="description">

Meet Vaishnavi - Our Software Design Maestro

Greetings, tech enthusiasts!<br> It's our pleasure to introduce the brilliant mind shaping the architecture and aesthetics of our software projects - Vaishnavi. As a skilled software designer, Vaishnavi is the driving force behind the seamless and intuitive experiences we deliver. Let's take a closer look at her powers.
<br>
Architectural Visionary:

Vaishnavi is not just a software designer; she's an architectural visionary who lays the foundation for our digital landscapes. Her expertise lies in crafting robust and scalable software solutions that stand the test of time.
Innovation at Core:
<br>
At the core of Vaishnavi's design philosophy is innovation.<br> She thrives on pushing the boundaries, introducing novel concepts, and ensuring that our software solutions are at the forefront of technological advancement.
            </p>
            <button class="btn">Contact</button>
        </div>
    </section>

</body>

</html>