<?php // -*- mode:php c-basic-offset: 2 -*-
// +-----------------------------------------------------------------------+
// | Piwigo RANDOM - Insert images from a Piwigo Galery in a website       |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2014 Matthieu Moy                                        |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or     |
// | (at your option) any later version.                                   |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

// Your piwigo gallery here:
$site = "https://gallery.patricklam.ca/";
$maximages = 1;
$cat_id = null;
$element_name = 'random_image';
$mode = 'javascript';
$target = '_blank';

//if (is_numeric($_GET['maximages']))
//{
//  $maximages = intval($_GET['maximages']);
//}

//if (is_numeric($_GET['cat_id']))
//{
//  $cat_id = intval($_GET['cat_id']);
//}

if (isset($_GET['element_name']))
{
  $element_name = $_GET['element_name'];
}

if (isset($_GET['target']))
{
  $element_name = $_GET['target'];
}

if (isset($_GET['mode']) && $_GET['mode'] == 'html') {
  $mode = 'html';
}

header('Content-Type: text/javascript');
$url = $site . "ws.php" .
  "?format=php" .
  "&method=pwg.categories.getImages" .
//  ($cat_id ? "&cat_id=" . $cat_id : "") .
  "&recursive=true" .
  "&per_page=" . $maximages .
  "&page=1" .
  "&order=random";
$response = file_get_contents($url);
$thumbc = unserialize($response);

if ($thumbc["stat"] === 'ok')
{
  foreach ($thumbc["result"]["images"] as $image)
  {
    $image_url = (string)$image['derivatives']['thumb']['url'];
    $page_url = (string)$image['page_url'];
    $comment = (string)$image['comment'];
    if ($comment === '') {
      $comment = "Random image";
    }
    $comment .= "\n(click for full-size)";
    if ($mode === 'javascript') {
      // Would be a bit simpler with jquery, but let's not
      // force it for such a simple piece of code.
      ?>
      var newImg = document.createElement("img");
      newImg.src = <?php echo json_encode($image_url); ?>;
      newImg.alt = "";
      newImg.title = <?php echo json_encode($comment) ?>;
      var newLink = document.createElement("a");
      newLink.href = <?php echo json_encode($page_url); ?>;
      newLink.id = "rndpic-a";
      newLink.appendChild(newImg);
      newLink.target = <?php echo json_encode($target); ?>;
      var target = document.getElementById(<?php echo json_encode($element_name); ?>);
      if (!target)
      {
        // Could not find #random_image. As a
        // fall-back, try to find the parent of the
        // <script> tag calling us.
        // http://stackoverflow.com/questions/6932679/get-dom-element-where-script-tag-is
        var target = document.documentElement;
        while (target.childNodes.length && target.lastChild.nodeType == 1)
        {
          target = target.lastChild;
        }
        target = target.parentNode;
      }
      target.appendChild(newLink);
      <?php
    } else if ($mode === 'html') {
      echo '<a id="rndpic-a" href="' . htmlspecialchars($page_url) . '"><img src="'
        . htmlspecialchars($image_url) . '" alt="" title="' . htmlspecialchars($comment) . '" />'
        . '</a>';
    }
  }
}
else
{
  // Silent error.
  // echo "Error";
}
