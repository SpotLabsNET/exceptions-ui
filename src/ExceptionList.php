<?php

namespace \Openclerk\Exceptions\Pages;

use \Openclerk\RoutedPage;
use \Openclerk\Permissions\Permissions;
use \Pages\PageRenderer;

class ExceptionList extends RoutedPage {

  public function render($arguments) {

    Permissions::need("exceptions");

    PageRenderer::header(array(
      "title" => t("Exception list"),
      "id" => "page_exception_list",
    ));

    PageRenderer::requireTemplate("exception_list", array());

    PageRenderer::footer();

  }

}

