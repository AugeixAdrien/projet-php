<?php


function displayMedocs()
{
    if (!isset ($_SESSION)) {
        session_start();
    }
    if (!isset ($_SESSION['login'])) {
        require_once "vue/formLogin.php";
    } else {
        $medicaments_json = file_get_contents('http://localhost/phpgroupe/api/medicaments.php');
        $medicaments = json_decode($medicaments_json, true);
        require_once "vue/detailsMedicaments.php";
    }
}

function loginUser($login, $password)
{
    session_start();
    if (!checkLogin($login, $password)) {
        $_SESSION['message'] = "Login ou mot de passe incorrect";
        require_once "vue/formLogin.php";
    } else {
        $_SESSION['login'] = $login;
        displayMedocs();
    }
}


function logoutUser()
{
    session_start();
    session_destroy();
    header("Location: index.php");
}


function details($id_medicament)
{
    try {
        $detail_json = file_get_contents('http://localhost/phpgroupe/api/medicaments.php?id=' . $id_medicament);
        //var_dump( $detail_json);

        $detail_json = str_replace("][", ",", $detail_json);
        $details = json_decode($detail_json, true);

        require_once "vue/descriptionMedoc.php";
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}

function conferences()
{
    $conferences_json = file_get_contents('http://localhost/phpgroupe/api/conferences.php');
    $conferences = json_decode($conferences_json, true);

    $utilisateurs_json = file_get_contents('http://localhost/phpgroupe/api/utilisateurs.php');
    $utilisateurs = json_decode($utilisateurs_json, true);

    require_once "vue/conference.php";
} 

function rejoindreAct(){
    $data = array('id_user' => $_POST["user-select"], 'id_act' => $_POST["id_act"]);
    $options = array('http' => array('header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content'=> http_build_query($data)));
    $appel = 'http://localhost/phpgroupe/api/conferences.php'; // Define the URL directly

    $context = stream_context_create($options);
    $result = file_get_contents($appel, false, $context);
    if($result === FALSE){
        // Handle error if needed
    }

    var_dump($result);

}

function juridique()
{
    require_once "vue/juridique.php";
}

?>