<?php

namespace Openclerk\Exceptions\Pages;

use \Openclerk\RoutedPage;
use \Openclerk\Permissions\Permissions;
use \Pages\PageRenderer;

class ExceptionList extends RoutedPage {

  public function render($arguments) {

    PageRenderer::addTemplatesLocation(__DIR__ . "/../templates");

    Permissions::need("exceptions");

    PageRenderer::header(array(
      "title" => t("Exception list"),
      "id" => "page_exception_list",
    ));

    $limit = (int) (isset($arguments['limit']) ? $arguments['limit'] : 10);

    $q = db()->prepare("SELECT * FROM uncaught_exceptions ORDER BY id desc LIMIT $limit");
    $q->execute();
    $exceptions = $q->fetchAll();

    PageRenderer::requireTemplate("exception_list", array(
      "exceptions" => $exceptions,
    ));

    PageRenderer::footer();

  }

  public function getPath() {
    return "admin/exceptions/list";
  }

}

