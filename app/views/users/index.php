<?php require APPROOT . '/views/includes/header_admin.php'; ?>
<?php require APPROOT . '/views/includes/navbar_admin.php'; ?>

<main class="admin__main">

    <?php
// $fb = initFacebook();

// try {
//     // Returns a `Facebook\FacebookResponse` object
//     // $response = $fb->get('/me/feed', $_SESSION['fb_access_token']);
//     $response = $fb->get(
//         '/me?fields=id,name,email,cover,gender,picture,link,friends,posts',
//         $_SESSION['fb_access_token']
//     );
// } catch (Facebook\Exceptions\FacebookResponseException $e) {
//     echo 'Graph returned an error: ' . $e->getMessage();
//     exit();
// } catch (Facebook\Exceptions\FacebookSDKException $e) {
//     echo 'Facebook SDK returned an error: ' . $e->getMessage();
//     exit();
// }
// $user = $response->getGraphUser();
// var_dump($user);
// var_dump($user['picture']);
// var_dump($user->getName());
// var_dump($user->getFirstName());
// var_dump($user->getLink());
// var_dump($user->getPicture());
// echo 'Name: ' . $user['name'];
// OR
// echo 'Name: ' . $user->getName();
?>
    <br>
    <!-- <img src="<?php echo $user['picture']['url']; ?>" alt=""> -->
    <!-- <?php echo $data['title']; ?> -->

</main>

<?php require APPROOT . '/views/includes/footer_admin.php'; ?> 