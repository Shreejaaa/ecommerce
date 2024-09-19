<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop Detail</title>
<link rel="stylesheet" href="CSS/shop_detail.css">
</head>
<body>

    <style>
        .sidebar {
          height: 100%;
          width: 200px;
          position: fixed;
          z-index: 1;
          margin-top: -20px;
          left: 0;
          background-color: #a5c9ed;
          overflow-x: hidden;
          padding-top: 10px;
        }
        .sidebar a {
          padding: 10px 15px;
          text-decoration: none;
          font-size: 18px;
          color: white;
          display: block;
          border-bottom: 1px solid #444;
        }
        .sidebar a:hover {
          color: #f1f1f1;
          background-color: #575757;
        }
        #homeLink {
          padding: 20px 15px;
          height: 30px;
          line-height: 50px;
        }
        .content {
          margin-left: 250px;
          padding: 1px 16px;
          height: 1000px;
        }

        /* .image-box {
    display: inline-block;
    margin-left: 330px;
    margin-top: 300px;
    border: 1px solid #ccc; /* Border style */
  /* }

  .image-box img {
    display: block; /* Ensures the image is not affected by margins */
    /* width: 200px;
    height: 150px;
  }  */ 


  .image-box {
    display: inline-block;
    margin-left: 330px;
    margin-top: 300px;
    border: 1px solid #ccc; /* Border style */
    padding: 10px; /* Add padding to create space around the button */
    text-align: center; /* Center the button horizontally */
  }

  .image-box img {
    display: block; /* Ensures the image is not affected by margins */
    width: 200px;
    height: 150px;
  }



      </style> 
      <div class="sidebar">
        <img src="images/LOGO.png" alt="Logo" width="150px" height="100px">
      
        <a href="#home" id="homeLink"><img src="images/HOME.png"alt="Home" width="30px" height="30px"> Home</a>
        <a href="#analytics"><img src="images/ANALYTICS.png"alt="Analytics"  width="30px" height="30px"> Analytics</a>
        <a href="#products"><img src="images/PRODUCT.png"alt="Analytics"  width="30px" height="30px"> Products</a>
        <a href="#orders"> <img src="images/ORDERS.png"alt="Home" width="30px" height="30px"> Orders</a>
        <a href="#shop"> <img src="images/SHOP.png"alt="Home" width="30px" height="30px"> Shop</a>
        <a href="#settings"> <img src="images/SETTING.png"alt="Home" width="30px" height="30px"> Settings</a>
        <a href="#log out"> <img src="images/log out.png" alt="Log out" width="30px" height="30px"> log out</a> 
        
      </div>
      
    
           <div class="search">
            <div class = "text">
            <form action="/search" method="GET">
                <input type="text" name="q" placeholder="Search">
                <button type="submit"><i class="fas fa-search"></i></button>

                <div class="user-info">
                  <img src="images/USER.png" alt="User" width="30px" height="30px">
                </div>
                <div class="trader-name">Trader Name</div>
            </div>
            </form>
          </div>
    
      
          <div class="name">
            Welcome Back, Trader_Name
            <div class="description">
              Here are today's stats from your Online Store!
          </div>
          
          <div class="button">
            <a href="Add" class="btn">ADD</a>
          </div>
          
        </div>

        

                <div class="image-box">
                  <img src="images/SHOP.png" alt="Image 1">
                   <style>
                     .image-box {
                        margin: 10px; 
                        margin-top:10%;
                        margin-left: 290px;

                       }
                  </style>
                

                </div>
                <div class="image-box">
                  <img src="images/SHOP.png" alt="Image 2">
                  
                </div>
                

              </form>
</body>
</html>
