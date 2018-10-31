<!DOCTYPE html>
<html lang="en-US">
<head>
    <style>
        html, body{
            height:100%;
        }
        .swal-modal{
            width:60%;
        }
        .swal-title{
            text-align:start;
        }
        body{
            background: url("{{URL::to('/')}}/template/images/padic0.jfif");
            background-size:100% 100%;
        }
    </style>
    <meta charset="utf-8">
    <script src="{{URL::to('/')}}/template/js/jquery.min.js"></script>
</head>
<body>

</body>
</html>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        // event.preventDefault();
        var role = '{{$role}}';
        if(role == 'physician'){
            cont = "Thank you for registering. " +
                    "Your personalised PIN (Personal Identification Number) will be emailed to the email address you provided " + 
                    "once we verify some details. " +
                    "This PIN number is your password to login to this site. Please keep it in a safe place."                    
        }
        else if(role == 'patient'){
            cont = "Thank you for registering. " + 
                   "Your personalised MRN (Medical Records Number) has been emailed to the email address you provided. " + 
                   "This MRN number is your password to login to this site. Please keep it in a safe place."
        }
        else if(role == 'subAdmin' || role == 'norole'){
            cont = "Thank you for registering. Please login to your account using your username and password. Padic Admin."
        }
        swal({
            title : cont,
            buttons : {
                Ok : true,
            },
        })
        .then((value) => {
            switch (value) {                
            case "Ok":
                var url ='{{URL::to('/login')}}';
                document.location.replace(url);    
            }
        });
    });
</script>
