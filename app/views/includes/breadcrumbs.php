<!-- ~~~ BREADCRUMBS start~~~ -->

<section class="full-width-section full-width-section--bg-breadcrumbs u-mb-big">
    <div class="full-width-section__content">
        <div class="full-width-section__wrapper">
            <div class="breadcrumbs">
                <?php
                $post_title = $data['post']->title ?? '';
                $params = new BreadcrumbsParams();
                $params->separator = ' / ';
                $params->home = 'Home';
                $params->post_title = $post_title;
                echo breadcrumbs($params);
                // echo breadcrumbs(' / ', 'Home', $post_title);
                ?>
            </div>
        </div>
    </div>
</section>
<!-- ~~~ BREADCRUMBS end~~~ -->