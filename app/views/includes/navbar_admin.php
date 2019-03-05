<div class="admin">
    <header class="admin__header">
        <div class="admin__logo">Oil Discovery <span>Admin</span></div>
        <div class="admin__user-name">
            G'day, <span>
                <?php echo $_SESSION['login_user_fname']; ?></span>!
        </div>
    </header>
    <div class="admin__content">
        <nav class="sidebar">
            <ul class="side-nav">
                <li class="side-nav__item">
                    <a class="side-nav__link side-nav__link--active" href="<?php echo URLROOT; ?>/posts">Go to Blog
                    </a>
                </li>
                <li class="side-nav__item">
                    <a class="side-nav__link " href="<?php echo URLROOT; ?>/posts/add">Add post</a>
                </li>
                <li class="side-nav__item">
                    <a class="side-nav__link" href="<?php echo URLROOT; ?>/users/search">Search users</a>
                </li>
                <li class="side-nav__item">
                    <a class="side-nav__link" href="<?php echo URLROOT; ?>/users/register">Register user</a>
                </li>
            </ul>
            <span class="legal">&copy; 2018</span>
        </nav> 