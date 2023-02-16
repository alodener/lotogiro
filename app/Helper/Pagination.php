<?php

namespace App\Helper;

class Pagination
{
    private $total;
    private $perPage;
    private $url;
    private $page;
    private $rows;
    private $pageVar;
    private $totalPages;

    public function __construct($total, $perPage, $pageVar, $page, $url)
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->page = ($page == 0 ? 1 : $page);
        $this->url = $url;
        $this->rows = array();
        $this->pageVar = $pageVar;
        $this->totalPages = ceil($this->total / ($this->perPage == 0 ? 1 : $this->perPage));
    }

    public function setRows(array $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getOffset()
    {
        if (ceil($this->total / $this->perPage) > 1) {
            return (int) $this->perPage * ($this->page - 1);
        }
        return 0;
    }

    public function getTotal()
    {
        return (int) $this->total;
    }

    public function getPage()
    {
        return intval($this->page);
    }

    public function getTotalPages()
    {
        return (int) $this->totalPages;
    }

    public function getHtml()
    {
        $totalPages = $this->totalPages;
        if ($totalPages < 1) {
            return '';
        }

        $url = preg_match("/\?/", $this->url) ? $this->url . '&' : $this->url . '?';
        $page = $this->page;
        $pageVar = $this->pageVar;

        $content = '';
        if ($totalPages > 1 && $page > 1) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=1' . '" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>';
        }

        if (($page - 3) > 0 && ($page - 3) < $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . ($page - 3) . '">' . ($page - 3) . '</a>
            </li>';
        }

        if (($page - 2) > 0 && ($page - 2) < $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . ($page - 2) . '">' . ($page - 2) . '</a>
            </li>';
        }

        if (($page - 1) > 0 && ($page - 1) < $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . ($page - 1) . '">' . ($page - 1) . '</a>
            </li>';
        }

        $content .= '
        <li class="active">
            <a class="page-link" href="' . $url . $pageVar . '=' . $page . '">' . $page . '</a>
        </li>';

        if (($page + 1) <= $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . ($page + 1) . '">' . ($page + 1) . '</a>
            </li>';
        }

        if (($page + 2) <= $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . ($page + 2) . '">' . ($page + 2) . '</a>
            </li>';
        }

        if (($page + 3) <= $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . ($page + 3) . '">' . ($page + 3) . '</a>
            </li>';
        }

        if ($totalPages > 1 && $page < $totalPages) {
            $content .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . $pageVar . '=' . $totalPages . '" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>';
        }

        $html = '
        <nav aria-label="Paginação">
            <ul class="pagination">
                ' . $content . '
            </ul>
        </nav>';

        return $html;
    }
}
