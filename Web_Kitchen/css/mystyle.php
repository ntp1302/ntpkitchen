<style>
    html, body {
        height: 100%;
        margin: 0;
        font-family: Tahoma;
        font-weight: bolder;
        font-size: 20px;
    } 
    .wrapper{
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color:#f1f1f1;
    }  
    .main{
        flex: 1;
        min-height:200px; 
        margin: 0px 30px 10px 50px
    }
    .navbar-light .navbar-nav .nav-link {
        color: white;
    }
    .navbar-light .navbar-nav .nav-link p{
        color:dimgray;
        margin:0;
        display: inline;
    }
    .navbar-light .navbar-nav .nav-link:hover {
        color: greenyellow;
    }
    .navbar-light .navbar-nav .nav-link p:hover{
        color: black;
    }
    .navbar-light .navbar-nav .nav-link #hot:hover{
        color: red;
    }
    .navbar-light .navbar-nav .nav-link #ql:hover{
        color: blue;
    }
    #footer1{
        padding:5px 20px;
        background-color: #f1f1f1;
    }
    #footer1 p{
        color:black;
        font-weight: 100;
        font-size:15px;
    }
    #footer1 p b{
        font-weight: bold;
    }
    #footer2{
        background-color: #009966;
        min-height: 70px;
        padding:5px 20px;
        text-align: center;
        font-weight:100;
        color:black;
        margin: 0;
    }
    #footer2 .col a,
    #footer2 .col p {
        display: inline;
        margin: 0; 
    }
    #footer2 .icon img{
        width: 4%;
    }
    #footer2 .icon img:hover{
        background-color: #f1f1f1;
        border-radius: 50%;
    }
    .logo{
        margin-top:15px;
        width: 28%;
        padding-left: 20px;
    }
    .category_product{
        background-color: white;
        padding: 10px;
        margin-top: 10px;
    }
    .category_product .banner-1{
        border-bottom: 2px solid green;
    }
    .category_product .banner-1 .banner-2{
        background-color: #009966;
        padding: 10px;
        width: 320px;
        height: 50px;
        color: white;
    }
    .category_product .banner-1 .banner-2 img{
        width: 30px;
        border-radius: 5px;
    }
    .category_product .row .col-3:hover{
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }
    .column {
            margin: 15px 15px 0;
            padding: 0;
        }

            .column:last-child {
                padding-bottom: 60px;
            }

            .column::after {
                content: '';
                clear: both;
                display: block;
            }

            .column div {
                position: relative;
                float: left;
                width: 300px;
                height: 200px;
                margin: 0 0 0 25px;
                padding: 0;
            }

                .column div:first-child {
                    margin-left: 0;
                }

        figure {
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .hover01 figure img {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-transition: .3s ease-in-out;
            transition: .3s ease-in-out;
        }

        .hover01 figure:hover img {
            -webkit-transform: scale(1.3);
            transform: scale(1.3);
        }

        input {
            border-radius: 4px;
        }

            input[type="submit"]:hover {
                opacity: 0.5;
            }

            input[type="text"]:hover {
                border: 1px solid;
                border-color: darkblue;
            }

            input[type="password"]:hover {
                border: 1px solid;
                border-color: darkblue;
            }

        .btn-primary:hover {
            opacity: 0.5;
        }
        .tab {
            overflow: hidden;
            border: none;
            background-color: white;
        }

            .tab button {
                background-color: #ddd;
                float: left;
                border: 1px solid #ccc;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                font-size: 17px;
                opacity: 0.5;
                margin-right: 2px;
            }

                .tab button:hover {
                    background-color: white;
                    border-top-color: blue;
                    opacity: 1;
                }

                .tab button.active {
                    background-color: white;
                    border-top-color: blue;
                    opacity: 1;
                }

        .tabcontent {
            display: none;
            padding: 30px;
            border: 1px solid #ccc;
            text-align: left;
            background-color: white;
        }

            .tabcontent table tr {
                height: 50px;
                border-bottom: 1px solid #ddd;
                color: #666666;
                font-weight: 200;
            }

    .register{
        background-color: white;
        margin: 20px 20%;
        padding: 20px 0px;
        text-align: center;
        border-radius: 20px;
    }
    .login_form{
        background-color:white; 
        padding: 20px; 
        margin: 20px 20%; 
        border-radius:20px
    }
    .login_form .text-center{
        font-weight: bold;
    }
    .about_form{
        background-color:white; 
        padding: 20px; 
        margin: 20px 50px; 
        border-radius:20px;
        font-weight: normal;
    }
    .all_product{
        background-color:white; 
        padding: 20px; 
        margin: 20px 0px; 
        border-radius:20px;
        font-weight: normal;
    }
    .edit_product{
        background-color:white; 
        padding: 20px; 
        margin: 20px 0px; 
        border-radius:20px;
        font-weight: normal;
    }
    .new_product{
        background-color:white; 
        padding: 20px; 
        margin: 20px 0px; 
        border-radius:20px;
        font-weight: normal;
    }
    .category_products{
        background-color:white; 
        padding: 20px; 
        margin: 20px 0px; 
        border-radius:20px;
        font-weight: normal;
    }
    .update_product{
        background-color:white; 
        padding: 20px; 
        margin: 20px 0px; 
        border-radius:20px;
        font-weight: normal;
    }
</style>