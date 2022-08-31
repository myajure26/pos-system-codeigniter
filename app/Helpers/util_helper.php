<?php

// Sanar una cadena
function cleanString($str, $type)
{
    $search = array(
        '@<script[^>]*?>.*?</script>@si',
        '@<[\/\!]*?[^<>]*?>@si',
        '@<style[^>]*?>.*?</style>@siU',
        '@<![\s\S]*?--[ \t\n\r]*>@siU',
        "/\\\\n/"
    );

    $str = ini_get('magic_quotes_gpc') ? stripslashes($str) : $str;
    $str = strip_tags(preg_replace($search, '', $str));
    $str = trim($str);
    $str = htmlspecialchars($str);
    $str = stripslashes($str);
    $str = addslashes($str);

    if($type == 'string'){

        $str = filter_var($str, FILTER_SANITIZE_STRING);

    }elseif($type == 'email'){

        $str = filter_var($str, FILTER_SANITIZE_EMAIL);


    }elseif($type == 'int'){

        $str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);

    }
                    
    return $str;
}

// Plugin Sweet Alert
function sweetAlert($data)
{
    if($data['alert'] == "simple"){
        $alert = " 
            <script>
                Swal.fire({
                    icon: '".$data['type']."',
                    title: '".$data['title']."',
                    text: '".$data['text']."'
                });
            </script>
        ";

    }elseif($data['alert'] == "reload") {

        $alert = " 
            <script>
                Swal.fire({
                    icon: '".$data['type']."',
                    title: '".$data['title']."',
                    text: '".$data['text']."',
					timer: 2500,
					timerProgressBar: true,
                    showConfirmButton: false
                    }).then(function(){
                        window.location.href = '".$data['url']."'
                    });
            </script>
        ";

    }elseif($data['alert'] == "clean") {

        $alert = " 
            <script>
                Swal.fire({
                    icon: '".$data['type']."',
                    title: '".$data['title']."',
                    text: '".$data['text']."',
                    confirmButtonText: 'OK'
                    }).then(function(){
	                    $('form')[0].reset();
	                    $('.img').attr('src', '../../assets/images/users/anonymous.png');
                    });
            </script>
        ";

    }elseif($data['alert'] == "redirect") {

        $alert = " 
            <script>
                Swal.fire({
                    icon: '".$data['type']."',
                    title: '".$data['title']."',
                    text: '".$data['text']."',
                    confirmButtonText: 'IR'
                    }).then(function(){
                        window.location.href = '/'
                    });
            </script>
        ";

    }

    return $alert;
}

// Mensajes de Bootstrap
function alert($data){

    $alert = '

        <div class="alert alert-'.$data['type'].'" role="alert">
            <span class="alert-inner--icon"><i class="'.$data['icon'].'"></i></span>
            <span class="alert-inner--text">'.$data['text'].'</span>
        </div>

    ';

    return $alert;

}
