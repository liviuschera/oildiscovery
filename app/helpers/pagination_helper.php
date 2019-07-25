<?php

/**
 * Paginate content
 *
 * @param int $row_count number of rows to be displayed
 * @return string
 */
function paginate($row_count)
{
    $html = '';
    $page = 1;
    $offset = 0;

    if (
        isset($_SESSION['row_count_users']) &&
        $row_count === $_SESSION['row_count_users']
    ) {
        $row_count = $_SESSION['row_count_users'];
        $max_row_per_page = ROWS_PER_PAGE_USERS;
        unset($_SESSION['row_count_users']);
    } elseif (
        isset($_SESSION['row_count_posts']) &&
        $row_count === $_SESSION['row_count_posts']
    ) {
        $row_count = $_SESSION['row_count_posts'];
        $max_row_per_page = ROWS_PER_PAGE_POSTS;
        unset($_SESSION['row_count_posts']);
    }
    // var_dump("row_count: {$row_count}");

    // if (!empty($_POST['page'])) {
    //     //  Check if pagination link was clicked
    //     $page = $_POST['page'];
    //     $_SESSION['offset'] = ($page - 1) * $max_row_per_page;
    //     // var_dump("offset: {$_SESSION['offset']}");
    //     // $max_rows = $row_count - $_SESSION['offset'];
    //     //     var_dump("limit max_rows: {$max_rows}");
    // }
    if (!empty($_POST['page'])) {
        //  Check if pagination link was clicked
        $page = $_POST['page'];
        $offset = ($page - 1) * $max_row_per_page;
    }

    if (!empty($row_count)) {
        $html .= "<div class='full-width-section__row u-mt-big'>";
        //   Setting how many pagination buttons to be displayed
        $page_count = ceil($row_count / $max_row_per_page);
        $_SESSION['max_rows_limit'] = ceil($row_count / $max_row_per_page);
        if ($page_count > 1) {
            //   Display pagination only if number of table rows is greater than ROWS_PER_PAGE_USERS
            for ($i = 1; $i <= $page_count; $i++) {
                if ($i == $page) {
                    $html .= "<form action='' method='post' class='pagination u-mt-big'>
                    <input type='submit' name='page' value={$i} class='button button__pagination button__pagination--active' />
                    </form>
                    ";
                } else {
                    $html .= "<form action='' method='post'  class='u-mt-big'>
                    <input type='submit' name='page' value={$i} class='button button__pagination' />
                    </form>";
                }
            }
        }
        $html .= "</div>";
    }

    return $html;
}
