<?php

/**
 * Paginate content
 *
 * @param int $row_count
 * @return string
 */
function paginate($row_count)
{
    $html = '';
    $page = 1;
    $offset = 0;

    if (!empty($_POST['page'])) {
        //  Check if pagination link was clicked
        $page = $_POST['page'];
        $offset = ($page - 1) * ROWS_PER_PAGE_USERS;
    }

    if (!empty($row_count)) {
        $html .= "<div class='full-width-section__row u-mt-big'>";
        //   Setting how many pagination buttons to be displayed
        $page_count = ceil($row_count / ROWS_PER_PAGE_USERS);
        if ($page_count > 1) {
            //   Display pagination only if number of table rows is greater than ROWS_PER_PAGE_USERS
            for ($i = 1; $i <= $page_count; $i++) {
                if ($i == $page) {
                    $html .= "<form action='' method='post' class='u-mt-big'>
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
?>
