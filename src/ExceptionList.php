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

    $limit = (isset($arguments['limit']) ? $arguments['limit'] : 10);
    $class = isset($arguments['limit']) ? $arguments['limit'] : null;
    $important = isset($arguments['important']) ? $arguments['important'] : null;
    $ignored = isset($arguments['ignored']) ? $arguments['ignored'] : null;

    $q = db()->prepare("SELECT * FROM uncaught_exceptions ORDER BY id desc LIMIT " . (int) $limit);
    $q->execute();
    $exceptions = $q->fetchAll();

    PageRenderer::requireTemplate("exception_list", array(
      "exceptions" => $exceptions,
      "url" => url_for($this->getPath(), array(
        "limit" => $limit,
        "class" => $class,
        "important" => $important,
        "ignored" => $ignored,
      )),
    ));

    PageRenderer::footer();

  }

  public function getPath() {
    return "admin/exceptions/list";
  }

}

