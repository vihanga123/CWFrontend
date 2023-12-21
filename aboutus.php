<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./aboutus.css">
    <title>About Us | Eco Enforce</title>
</head>
<script>
  if (!sessionStorage.getItem("username")) {
    setTimeout(function() {
      window.location.href = "login.php";
    }, 100); // 1000 milliseconds = 1 second
}</script>
<body>
    <?php include('header.html'); ?>

    <section class="about-us-section">
        <img src="./images/pexels-frans-van-heerden-1912176.croped.jpg" alt="About Us Image">
        <div class="image-text-overlay">
            <p>About Us</p>
        </div>
    </section>

    <section class="content-section">
        <h1>Eco Enforce</h1>
        <p>
            Welcome to Eco Enforce, your dedicated online platform for environmental vigilance and advocacy.
            We believe in the potential of collective action to safeguard our unique wildlife and forests at Eco Enforce. 
            Our platform acts as a key link between concerned citizens and the organizations in charge of wildlife and forest 
            conservation.
        </p>
        <br>
        <p>
            Eco Enforce empowers people to be the voice for those who cannot speak for themselves in a world where 
            environmental crimes pose an escalating threat to the delicate balance of our ecosystems. Whether you've 
            witnessed illegal logging, poaching, or any other behaviour endangering the health of our natural environments, 
            Eco Enforce offers a streamlined and user-friendly interface for reporting and addressing your concerns.
        </p>
        <br>
        <p>
            Our objective is simple but profound: to make it easier to report animal and forest crimes and to ensure that these complaints 
            reach the right authorities as soon as possible. Eco Enforce leverages the power of technology to harness the potential of a linked 
            global society, forming a network of watchful individuals dedicated to preserving the biodiversity that sustains life on Earth.
        </p>
        <br>
        <p>
            How does it work? Users may quickly lodge complaints using our user-friendly web system, providing critical information regarding the 
            witnessed instances. These reports are then easily submitted to the appropriate wildlife and forest conservation institutes. 
            Eco Enforce transforms individual acts into a collective force for environmental protection by facilitating open contact between concerned 
            citizens and devoted conservation organizations.
        </p>
        <br>
        <p>
            Join us on this life-changing adventure towards a more sustainable and harmonious cohabitation with nature. Contribute to the ongoing efforts 
            to conserve our planet's biodiversity by using Eco Enforce to report and combat environmental crimes and Nurture Nature!
        </p>
    </section>

    <section class="last-content-section">
        <h1>Institutions</h1>
        
        <div class="content-container">
            <div class="left-container">
                <img src="./path/to/your/left-image.jpg" alt="Left Image">
            </div>
            
            <div class="right-container">
                <p>Wildlife conservation institutes are critical to protecting biodiversity and preventing wildlife crime. These organizations work to protect 
                    endangered animals and their habitats through anti-poaching campaigns, partnerships with law enforcement, public awareness campaigns, and 
                    research. Their initiatives against wildlife crime, in particular, include strong steps to curb illicit activities such as poaching and 
                    trafficking, to protect vulnerable species and maintain the biological balance of natural habitats.</p>
            </div>
        </div>
        <br>
        <div class="content-container">
            <div class="left-container">
                <img src="./images/pexels-jahoo-clouseau-1260324.jpg" alt="Left Image">
            </div>
            <div class="right-container">
                <p>Forest conservation institutions work to maintain and manage forest ecosystems in a sustainable manner. Their primary duty is 
                    to protect the essential homes of numerous plant and animal species, to sustain biodiversity, and to protect the ecological 
                    services that forests provide. To combat deforestation, illegal logging, and other threats to forests, these institutes use tactics 
                    such as replanting, habitat restoration, and community engagement.</p>
            </div>
        </div>
    </section>

    <?php include('footer.html'); ?>
</body>
</html>