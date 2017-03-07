<?php declare(strict_types = 1);

// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

// lib/php/plugins/contact.php 20150101 - 20170305

class Plugins_Contact extends Plugin
{
    public function read() : string
    {
        $buf = '
      <h2>Email Contact Form</h2>
      <form id="contact-send" method="post" onsubmit="return mailform(this);">
        <p><input id="subject" required="" type="text" placeholder="Message Subject"></p>
        <p><textarea id="message" rows="9" required="" placeholder="Message Content"></textarea></p>
        <p class="text-right">
          <small>(Note: Doesn\'t seem to work with Firefox 50.1)</small>
          <input class="btn" type="submit" id="send" value="Send">
        </p>
      </form>';

        $js = '
      <script>
function mailform(form) {
    location.href = "mailto:' . $this->g->email . '"
        + "?subject=" + encodeURIComponent(form.subject.value)
        + "&body=" + encodeURIComponent(form.message.value);
    form.subject.value = "";
    form.message.value = "";
    alert("Thank you for your message. We will get back to you as soon as possible.");
    return false;
}
      </script>';
        return $this->t->read(['buf' => $buf, 'js' => $js]);
    }
}

// lib/php/plugins/about.php 20150101 - 20170305

class Plugins_About extends Plugin
{
    public function read() : string
    {
        $buf = '
      <h2>About</h2>
      <p>
This is an example of a simple PHP7 "framework" to provide the core
structure for further experimental development with both the framework
design and some of the new features of PHP7.
      </p>
      <form method="post">
        <p class="text-center">
          <a class="btn btn-success" href="?o=about&l=success:Howdy, all is okay.">Success Message</a>
          <a class="btn btn-danger" href="?o=about&l=danger:Houston, we have a problem.">Danger Message</a>
          <a class="btn btn-secondary" href="#" onclick="ajax(\'1\')">JSON</a>
          <a class="btn btn-secondary" href="#" onclick="ajax(\'\')">HTML</a>
          <a class="btn btn-secondary" href="#" onclick="ajax(\'foot\')">FOOT</a>
        </p>
      </form>
      <pre id="dbg"></pre>
      <script>
function ajax(a) {
  if (window.XMLHttpRequest)  {
    var x = new XMLHttpRequest();
    x.open("POST", "", true);
    x.onreadystatechange = function() {
      if (x.readyState == 4 && x.status == 200) {
        document.getElementById("dbg").innerHTML = x.responseText
          .replace(/</g,"&lt;")
          .replace(/>/g,"&gt;")
          .replace(/\\\n/g,"\n")
          .replace(/\\\/g,"");
    }}
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    x.send("o=about&x="+a);
    return false;
  }
}
      </script>';
        return $this->t->read(['buf' => $buf]);
    }
}

// lib/php/plugins/home.php 20150101 - 20170305

class Plugins_Home extends Plugin
{
    public function read() : string
    {
        if (empty($_SESSION['l'])) {
            $ts = util::ses('timestamp', time());
            util::log("You first visited this page "  . util::now($ts), 'success');
        }

        $buf = '
      <h2>Home</h2>
      <p>
This is an ultra simple single-file PHP7 framework and template system example.
Comments and pull requests are most welcome via the Issue Tracker link above.
      </p>
      <p class="text-center">
        <a class="btn btn-primary" href="https://github.com/markc/spe">Project Page</a>
        <a class="btn btn-primary" href="https://github.com/markc/spe/issues">Issue Tracker</a>
        <a class="btn btn-success" href="?t=none">No Theme</a>
        <a class="btn btn-success" href="?t=simple">Simple Theme</a>
        <a class="btn btn-success" href="?t=bootstrap">Bootstrap 4</a>
      </p>';
        return $this->t->read(['buf' => $buf]);
    }
}

// lib/php/plugins/news.php 20150101 - 20170306

class Plugins_News extends Plugin
{
    protected
    $tbl = 'news',
    $in = [
        'title'     => '',
        'author'    => '',
        'content'   => '',
    ];
}

// lib/php/plugins/users.php 20150101 - 20170306

class Plugins_Users extends Plugin
{
    protected
    $tbl = 'users',
    $in = [
        'userid'    => '',
        'acl'       => 0,
        'fname'     => '',
        'lname'     => '',
        'altemail'  => '',
        'webpw'     => '',
        'otp'       => '',
        'anote'     => '',
    ];
}

// lib/php/themes/simple/contact.php 20150101 - 20170305

class Themes_Simple_Contact extends Themes_Simple_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'] . $in['js'];
    }
}

// lib/php/themes/simple/about.php 20150101 - 20170305

class Themes_Simple_About extends Themes_Simple_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/simple/home.php 20150101 - 20170305

class Themes_Simple_Home extends Themes_Simple_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/simple/theme.php 20150101 - 20170305

class Themes_Simple_Theme extends Theme
{
    public function css() : string
    {
        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,300italic" rel="stylesheet" type="text/css">
    <style>
* { transition: 0.25s linear; }
body {
    background-color: #fff;
    color: #444;
    font-family: "Roboto", sans-serif;
    font-weight: 300;
    height: 50rem;
    line-height: 1.5;
    margin: 0 auto;
    max-width: 50rem;
}
h1, h2, h3, nav, footer {
    color: #0275d8;
    font-weight: 300;
    text-align: center;
    margin: 0.5rem 0;
}
nav a, .btn {
    background-color: #ffffff;
    border-radius: 0.2em;
    border: 0.01em solid #0275d8;
    display: inline-block;
    padding: 0.25em 1em;
    font-family: "Roboto", sans-serif;
    font-weight: 300;
    font-size: 1rem;
}
nav a:hover, button:hover, input[type="submit"]:hover, .btn:hover, .bg-primary  {
    background-color: #0275d8;
    color: #fff;
    text-decoration: none;
}
label, input[type="text"], input[type="email"], input[type="password"], textarea, pre {
    display: inline-block;
    width: 100%;
    padding: 0.5em;
    font-size: 1rem;
    box-sizing : border-box;
}
form { margin: 0 auto; width: 30rem; }
p, pre, ul { margin-top: 0; }
a:link, a:visited { color: #0275d8; text-decoration: none; }
a:hover { text-decoration: underline; }
a.active { background-color: #2295f8; color: #ffffff; }
a.active:hover { background-color: #2295f8; }
table { width: 100%; }
table td { padding: 0.25em 1em; }
.w100 { width: 100px; }
.w150 { width: 150px; }
.w200 { width: 200px; }
.text-right { text-align: right; }
.text-center { text-align: center; }
.alert { padding: 0.5em; text-align: center; border-radius: 0.2em; }
.success, .btn-success { background-color: #dff0d8; border-color: #d0e9c6; color: #3c763d; }
.danger, .btn-danger { background-color: #f2dede; border-color: #ebcccc; color: #a94442; }
.tblbg { background-color: #efefef; }
.top { vertical-align:  top; }
@media (max-width: 46rem) { body { width: 92%; } }
        </style>';
    }
}

// lib/php/themes/simple/users.php 20150101 - 20170306

class Themes_Simple_Users extends Themes_Simple_Theme {

    public function create(array $in) : string
    {
        return $this->editor($in);
    }

    public function read(array $in) : string
    {
        $buf = '';
        $num = count($in);

        foreach ($in as $a) {
            extract($a);
            $buf .= '
        <tr>
          <td>
            <a href="?o=users&m=read&i=' . $id . '" title="Show user">
              <strong>' . $userid . '</strong>
            </a>
          </td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td>' . $this->g->acl[$acl] . '</td>
        </tr>';
        }

        return '
          <h2><a href="?o=users&m=create" title="Add new user"><b>Users (+)</b></a></h3>
          <table>
            <thead class="nowrap">
              <tr class="bg-primary text-white">
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Alt Email</th>
                <th>ACL</th>
              </tr>
            </thead>
            <tbody>' . $buf . '
            </tbody>
          </table>';
    }

    public function read_one(array $in) : string
    {
        return $this->editor($in);
    }

    public function update(array $in) : string
    {
        return $this->editor($in);
    }

    private function editor(array $in) : string
    {
        extract($in);

        $header = $this->g->in['m'] === 'create' ? 'Add User' : 'Update User';
        $submit = $this->g->in['m'] === 'create' ? '
              <a class="btn" href="?o=users&m=read&i=0">&laquo; Back</a>
              <button type="submit" name="m" value="create" class="btn btn-success">Add This Item</button>' : '
              <a class="btn" href="?o=users&m=read&i=0">&laquo; Back</a>
              <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $userid . '?\')">Remove</a>
              <button type="submit" name="m" value="update" class="btn btn-success">Update</button>';

        return '
          <h2><a href="?o=users&m=read&i=0"><b>&laquo; ' . $header . '</b></a></h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <input type="hidden" name="i" value="' . $this->g->in['i'] . '">

            <input type="hidden" name="acl" value="' . $acl . '">
            <input type="hidden" name="webpw" value="' . $webpw . '">

            <p>
              <label for="userid">UserID</label><br>
              <input type="email" id="userid" name="userid" value="' . $userid . '" required>
            </p>
            <p>
              <label for="fname">First Name</label><br>
              <input type="text" id="fname" name="fname" value="' . $fname . '" required>
            </p>
            <p>
              <label for="lname">Last Name</label><br>
              <input type="text" id="lname" name="lname" value="' . $lname . '" required>
            </p>
            <p>
              <label for="altemail">Alt Email</label><br>
              <input type="text" id="altemail" name="altemail" value="' . $altemail . '">
            </p>
            <p>
              <label for="password1">Password</label><br>
              <input type="password" name="passwd1" id="passwd1" value="">
            </p>
            <p>
              <label for="password2">Password Repeat</label><br>
              <input type="password" name="passwd2" id="passwd2" value="">
            </p>
            <p>
              <label for="anote">Admin Notes</label><br>
              <textarea rows="9" id="anote" name="anote">' . nl2br($anote) . '</textarea>
            </p>
            <br>
            <p class="text-right">' . $submit . '
            </p>
          </form>';
    }
}

// lib/php/themes/simple/news.php 20150101 - 20170305

class Themes_Simple_News extends Themes_Simple_Theme {

    public function create(array $in) : string
    {
        return $this->editor($in);
    }

    public function read(array $in) : string
    {
        $buf = '';
        foreach ($in as $row) {
            extract($row);
            $buf .= '
              <tr>
                <td class="nowrap tblbg">
                  <a href="?o=news&m=read&i=' . $id . '" title="Show item">
                    <strong>' . $title . '</strong>
                  </a>
                </td>
                <td class="text-center nowrap tblbg top w150" rowspan="2">
                  <small>
                    by <b>' . $author . '</b><br>
                    <i>' . util::now($updated) . '</i>
                  </small>
                </td>
              </tr>
              <tr>
                <td><p>' . nl2br($content) . '</p></td>
              </tr>';
        }

        return '
          <h2><b><a href="?o=news&m=create" title="Add news item">News (+)</a></b></h2>
          <table>
            <tbody>' . $buf . '
            </tbody>
          </table>';
    }

    public function read_one(array $ary) : string
    {
        extract($ary);

        return '
          <h2><b><a href="?o=news&m=read&i=0">&laquo; ' . $title . '</a></b></h2>
          <table>
            <tbody>
              <tr>
                <td>' . nl2br($content) . '</td>
                <td class="text-center nowrap tblbg w150">
                  <small>
                    by <b>' . $author . '</b><br>
                    <i>' . util::now($updated) . '</i>
                  </small>
                </td>
              </tr>
            </tbody>
          </table>
          <br>
          <p class="text-right">
            <a class="btn" href="?o=news&m=read&i=0">&laquo; Back</a>
            <a class="btn btn-danger" href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
            <a class="btn btn-success" href="?o=news&m=update&i=' . $id . '">Update</a>
          </p>';
    }

    public function update(array $in) : string
    {
        return $this->editor($in);
    }

    private function editor(array $ary) : string
    {
        extract($ary);
        $itemid = $this->g->in['m'] === 'create' ? 0 : $id;
        $header = $this->g->in['m'] === 'create' ? 'Add News' : 'Update News';
        $submit = $this->g->in['m'] === 'create' ? '
                <a class="btn" href="?o=news&m=read&i=0">&laquo; Back</a>
                <button class="btn btn-success" type="submit" name="i" value="0">Add This Item</button>' : '
                <a class="btn" href="?o=news&m=read&i=' . $id . '">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
                <button class="btn btn-success" type="submit" name="i" value="' . $id . '">Update</button>';

        return '
          <h2><a href="?o=news&m=read&i=' . $itemid . '"><b>&laquo; ' . $header . '</b></a></h2>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <p>
              <label for="title">Title</label><br>
              <input type="text" id="title" name="title" value="' . $title . '" required>
            </p>
            <p>
              <label for="author">Author</label><br>
              <input type="text" id="author" name="author" value="' . $author . '" required>
            </p>
            <p>
              <label for="content">Content</label><br>
              <textarea id="content" name="content" rows="9" required>' . $content . '</textarea>
            </p>
            <br>
            <p class="text-right">' . $submit . '
            </p>
          </form>';
    }

}

// lib/php/themes/none/theme.php 20150101 - 20170305

class Themes_None_Theme extends Theme {}

// lib/php/themes/none/about.php 20150101 - 20170305

class Themes_None_About extends Themes_None_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/none/contact.php 20150101 - 20170305

class Themes_None_Contact extends Themes_None_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/none/home.php 20150101 - 20170305

class Themes_None_Home extends Themes_None_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/none/users.php 20150101 - 20170306

class Themes_None_Users extends Themes_None_Theme {

    public function create(array $in) : string
    {
        return $this->editor($in);
    }

    public function read(array $in) : string
    {
        $buf = '';
        $num = count($in);

        foreach ($in as $a) {
            extract($a);
            $buf .= '
        <tr>
          <td>
            <a href="?o=users&m=read&i=' . $id . '" title="Show user">
              <strong>' . $userid . '</strong>
            </a>
          </td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td>' . $this->g->acl[$acl] . '</td>
        </tr>';
        }

        return '
          <h2><a href="?o=users&m=create" title="Add new user"><b>Users (+)</b></a></h3>
          <table>
            <thead class="nowrap">
              <tr class="bg-primary text-white">
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Alt Email</th>
                <th>ACL</th>
              </tr>
            </thead>
            <tbody>' . $buf . '
            </tbody>
          </table>';
    }

    public function read_one(array $in) : string
    {
        return $this->editor($in);
    }

    public function update(array $in) : string
    {
        return $this->editor($in);
    }

    private function editor(array $in) : string
    {
        extract($in);

        $header = $this->g->in['m'] === 'create' ? 'Add User' : 'Update User';
        $submit = $this->g->in['m'] === 'create' ? '
              <a class="btn" href="?o=users&m=read&i=0">&laquo; Back</a>
              <button type="submit" name="m" value="create" class="btn btn-success">Add This Item</button>' : '
              <a class="btn" href="?o=users&m=read&i=0">&laquo; Back</a>
              <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $userid . '?\')">Remove</a>
              <button type="submit" name="m" value="update" class="btn btn-success">Update</button>';

        return '
          <h2><a href="?o=users&m=read&i=0"><b>&laquo; ' . $header . '</b></a></h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <input type="hidden" name="i" value="' . $this->g->in['i'] . '">

            <input type="hidden" name="acl" value="' . $acl . '">
            <input type="hidden" name="webpw" value="' . $webpw . '">

            <p>
              <label for="userid">UserID</label><br>
              <input type="email" id="userid" name="userid" value="' . $userid . '" required>
            </p>
            <p>
              <label for="fname">First Name</label><br>
              <input type="text" id="fname" name="fname" value="' . $fname . '" required>
            </p>
            <p>
              <label for="lname">Last Name</label><br>
              <input type="text" id="lname" name="lname" value="' . $lname . '" required>
            </p>
            <p>
              <label for="altemail">Alt Email</label><br>
              <input type="text" id="altemail" name="altemail" value="' . $altemail . '">
            </p>
            <p>
              <label for="password1">Password</label><br>
              <input type="password" name="passwd1" id="passwd1" value="">
            </p>
            <p>
              <label for="password2">Password Repeat</label><br>
              <input type="password" name="passwd2" id="passwd2" value="">
            </p>
            <p>
              <label for="anote">Admin Notes</label><br>
              <textarea rows="9" id="anote" name="anote">' . nl2br($anote) . '</textarea>
            </p>
            <br>
            <p class="text-right">' . $submit . '
            </p>
          </form>';
    }
}

// lib/php/themes/none/news.php 20150101 - 20170305

class Themes_None_News extends Themes_None_Theme
{
    public function create(array $in) : string
    {
        return $this->editor($in);
    }

    public function read(array $in) : string
    {
        $buf = '';
        foreach ($in as $row) {
            extract($row);
            $buf .= '
                <tr>
                  <td>
                    <a href="?o=news&m=read&i=' . $id . '" title="Show item">
                      <strong>' . $title . '</strong>
                    </a>
                  </td>
                  <td rowspan="2">
                    <small>
                      by <b>' . $author . '</b><br>
                      <i>' . util::now($updated) . '</i>
                    </small>
                  </td>
                </tr>
                <tr>
                  <td><p>' . nl2br($content) . '</p></td>
                </tr>';
        }

        return '
          <h3><a href="?o=news&m=create" title="Add news item">News (+)</a></h3>
          <table>
            <tbody>' . $buf . '
            </tbody>
          </table>';
    }

    public function read_one(array $ary) : string
    {
        extract($ary);

        return '
          <h3><a href="?o=news&m=read&i=0">&laquo; ' . $title . '</a></h3>
          <table>
            <tbody>
              <tr><td>' . nl2br($content) . '<br></td><tr>
              </tr><td><small><i>by <b>' . $author . '</b> ' . util::now($updated) . '</i></small></td></tr>
            </tbody>
          </table>
          <p>
            <a href="?o=news&m=read&i=0">&laquo; Back</a>
            | <a href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
            | <a href="?o=news&m=update&i=' . $id . '">Update</a>
          </p>';
    }

    public function update(array $in) : string
    {
        return $this->editor($in);
    }

    private function editor(array $ary) : string
    {
        extract($ary);
        $itemid = $this->g->in['m'] === 'create' ? 0 : $id;
        $header = $this->g->in['m'] === 'create' ? 'Add News' : 'Update News';
        $submit = $this->g->in['m'] === 'create' ? '
              <a href="?o=news&m=read&i=0">&laquo; Back</a>
              <button type="submit" name="i" value="0">Add This Item</button>' : '
              <a href="?o=news&m=read&i=' . $id . '">&laquo; Back</a>
              <a href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
              <button type="submit" name="i" value="' . $id . '">Update</button>';

        return '
          <h3><a href="?o=news&m=read&i=' . $itemid . '">&laquo; ' . $header . '</a></h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <p>
              <label for="title">Title</label><br>
              <input type="text" id="title" name="title" value="' . $title . '" required>
            </p>
            <p>
              <label for="author">Author</label><br>
              <input type="text" id="author" name="author" value="' . $author . '" required>
            </p>
            <p>
              <label for="content">Content</label><br>
              <textarea id="content" name="content" rows="9" required>' . $content . '</textarea>
            </p>
            <p>' . $submit . '
            </p>
          </form>';
    }

}

// lib/php/themes/bootstrap/contact.php 20150101 - 20170305

class Themes_Bootstrap_Contact extends Themes_Bootstrap_Theme
{
    public function read(array $in) : string
    {
        return '
        <div class="col-md-4 offset-md-4">
          <h2><i class="fa fa-envelope"></i> Contact us</h2>
          <form action="' . $this->g->self . '" method="post" onsubmit="return mailform(this)">
            <input type="hidden" name="o" value="auth">
            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" class="form-control" id="subject" placeholder="Your Subject" required>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" rows="9" placeholder="Your Message" required></textarea>
            </div>
            <div class="form-group">
              <a tabindex="0" role="button" data-toggle="popover" data-trigger="hover" title="Please Note" data-content="Submitting this form will attempt to start your local mail program. If it does not work then you may have to configure your browser to recognize mailto: links."> <i class="fa fa-question-circle fa-fw"></i></a>
              <div class="btn-group pull-right">
                <button class="btn btn-primary" type="submit">Send</button>
              </div>
            </div>
          </form>
        </div>
        <script> $(function() { $("[data-toggle=popover]").popover(); }); </script>' . $in['js'];
    }
}

// lib/php/themes/bootstrap/about.php 20150101 - 20170305

class Themes_Bootstrap_About extends Themes_Bootstrap_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/bootstrap/home.php 20150101 - 20170305

class Themes_Bootstrap_Home extends Themes_Bootstrap_Theme
{
    public function read(array $in) : string
    {
        return $in['buf'];
    }
}

// lib/php/themes/bootstrap/users.php 20170225

class Themes_Bootstrap_Users extends Themes_Bootstrap_Theme
{
    public function create(array $in) : string
    {
        return $this->editor($in);
    }

    public function read(array $in) : string
    {
        $buf = '';
        $num = count($in);

        foreach ($in as $a) {
            extract($a);
            $buf .= '
        <tr>
          <td>
            <a href="?o=users&m=read&i=' . $id . '" title="Show user">
              <strong>' . $userid . '</strong>
            </a>
          </td>
          <td>' . $fname . '</td>
          <td>' . $lname . '</td>
          <td>' . $altemail . '</td>
          <td>' . $this->g->acl[$acl] . '</td>
        </tr>';
        }

        return '
          <h3 class="min60">
            <a href="?o=users&m=create" title="Add new user">
              <i class="fa fa-users fa-fw"></i> Users
              <small>
                <i class="fa fa-plus-circle fa-fw"></i>
                <span class="badge badge-pill badge-default pull-right">' . $num . '</span>
              </small>
            </a>
          </h3>
          <div class="table-responsive">
            <table class="table table-sm min600">
              <thead class="nowrap">
                <tr class="bg-primary text-white">
                  <th>User ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Alt Email</th>
                  <th>ACL</th>
                </tr>
              </thead>
              <tbody>' . $buf . '
              </tbody>
            </table>
          </div>';
    }

    public function read_one(array $in) : string
    {
        return $this->editor($in);
/*
        extract($in);

        return '
          <h3 class="w30">
            <a href="?o=users&m=read&i=0">
              <i class="fa fa-users fa-fw"></i> ' . $userid . '
            </a>
            <small>&nbsp;ID: ' . $id . '</small>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>UserID:</b></label>
                  <p class="form-control-static col-sm-8"><a href="mailto:' . $userid . '">' . $userid . '</a></p>
                </div>
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Full Name:</b></label>
                  <p class="form-control-static col-sm-8">' . $fname . ' ' . $lname . '</p>
                </div>
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>ACL:</b></label>
                  <p class="form-control-static col-sm-8">' . $this->g->acl[$acl] . '</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Alt Email:</b></label>
                  <p class="form-control-static col-sm-8"><a href="mailto:' . $altemail . '">' . $altemail . '</a></p>
                </div>

                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Updated:</b></label>
                  <p class="form-control-static col-sm-8">' . $updated . '</p>
                </div>
                <div class="row">
                  <label class="col-sm-4 col-form-label"><b>Created:</b></label>
                  <p class="form-control-static col-sm-8">' . $created . '</p>
                </div>
              </div>
              <div class="col-md-4">
              <div class="row">
                <textarea rows="4" class="form-control" placeholder="Admin notes" disabled>' . nl2br($anote) . '</textarea>
              </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-right">
                <div class="btn-group">
                  <a class="btn btn-secondary" href="?o=users&m=read&i=0">&laquo; Back</a>
                  <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $userid . '?\')">Remove</a>
                  <a class="btn btn-primary" href="?o=users&m=update&i=' . $id . '">Update</a>
                </div>
              </div>
            </div>
          </form>';
*/
    }

    public function update(array $in) : string
    {
        return $this->editor($in);
    }

    private function editor(array $in) : string
    {


        extract($in);

//        $itemid = $this->g->in['m'] === 'create' ? 0 : $id;
        $header = $this->g->in['m'] === 'create' ? 'Add User' : 'Update User';
        $submit = $this->g->in['m'] === 'create' ? '
                <a class="btn btn-outline-primary" href="?o=users&m=read&i=0">&laquo; Back</a>
                <button type="submit" name="m" value="create" class="btn btn-primary">Add This Item</button>' : '
                <a class="btn btn-outline-primary" href="?o=users&m=read&i=0">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=users&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $userid . '?\')">Remove</a>
                <button type="submit" name="m" value="update" class="btn btn-primary">Update</button>';

        return '
          <h3 class="w30">
            <a href="?o=users&m=read&i=0">
              <i class="fa fa-users fa-fw"></i> ' . $header . '
            </a>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <input type="hidden" name="i" value="' . $this->g->in['i'] . '">

            <input type="hidden" name="acl" value="' . $acl . '">
            <input type="hidden" name="webpw" value="' . $webpw . '">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="userid">UserID</label>
                  <input type="email" class="form-control" id="userid" name="userid" value="' . $userid . '" required>
                </div>
                <div class="form-group">
                  <label for="fname">First Name</label>
                  <input type="text" class="form-control" id="fname" name="fname" value="' . $fname . '" required>
                </div>
                <div class="form-group">
                  <label for="lname">Last Name</label>
                  <input type="text" class="form-control" id="lname" name="lname" value="' . $lname . '" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="altemail">Alt Email</label>
                  <input type="text" class="form-control" id="altemail" name="altemail" value="' . $altemail . '">
                </div>
                <div class="form-group">
                  <label for="password1">Password</label>
                  <input type="password" class="form-control" name="passwd1" id="passwd1" value="">
                </div>
                <div class="form-group">
                  <label for="password2">Password Repeat</label>
                  <input type="password" class="form-control" name="passwd2" id="passwd2" value="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="anote">Admin Notes</label>
                  <textarea rows="9" class="form-control" id="anote" name="anote">' . nl2br($anote) . '</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="btn-group pull-right">' . $submit . '
                </div>
              </div>
            </div>
          </form>';
    }
}

// lib/php/themes/bootstrap/theme.php 20150101 - 20170305

class Themes_Bootstrap_Theme extends Theme
{
    public function css() : string
    {
        return '
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,300italic" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" rel="stylesheet" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <style>
* { transition: 0.2s linear; }
body { font-family: "Roboto", sans-serif; font-size: 17px; font-weight: 300; padding-top: 5rem; }
.w100 { width: 100px; }
.w200 { width: 200px; }
.w300 { width: 300px; }
.max200 { max-width: 200px; }
.min50  { min-width:  50px; }
.min100 { min-width: 100px; }
.min150 { min-width: 150px; }
.min200 { min-width: 200px; }
.min300 { min-width: 300px; }
.min400 { min-width: 400px; }
.min500 { min-width: 500px; }
.min600 { min-width: 600px; }
.nowrap { white-space: nowrap; }
    </style>';
    }

    public function log() : string
    {
        list($lvl, $msg) = util::log();
        return $msg ? '
      <div class="alert alert-' . $lvl . '">' . $msg . '
      </div>' : '';
    }

    public function head() : string
    {
        return '
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="' . $this->g->self . '"><b>' . $this->g->out['head'] . '</b></a>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">' . $this->g->out['nav1'] . '
        </ul>
      </div>
    </nav>';
    }

    public function nav1(array $a = []) : string
    {
        $a = isset($a[0]) ? $a : $this->g->nav1;
        $o = '?o=' . $this->g->in['o'];
        $t = '?t=' . $this->g->in['t'];
        return join('', array_map(function ($n) use ($o, $t) {
            if (is_array($n[1])) return $this->nav_dropdown($n);
            $c = $o === $n[1] || $t === $n[1] ? ' active' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i> ' : '';
            return '
          <li class="nav-item' . $c . '"><a class="nav-link" href="' . $n[1] . '">' . $i . $n[0] . '</a></li>';
        }, $a));
    }

    public function nav_dropdown(array $a = []) : string
    {
        $o = '?o=' . $this->g->in['o'];
        $i = isset($a[2]) ? '<i class="' . $a[2] . '"></i> ' : '';
        return '
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $i . $a[0] . '</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">'.join('', array_map(function ($n) use ($o) {
            $c = $o === $n[1] ? ' active' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i> ' : '';
            return '
              <a class="dropdown-item" href="' . $n[1] . '">' . $i . $n[0] . '</a>';
        }, $a[1])).'
            </div>
          </li>';
    }

    public function main() : string
    {
        return '
    <main class="container">
      <div class="row">
        <div class="col-12">' . $this->g->out['log'] . $this->g->out['main'] . '
        </div>
      </div>
    </main>';
    }
}

// lib/php/themes/bootstrap/news.php 20170225

class Themes_Bootstrap_News extends Themes_Bootstrap_Theme
{
    public function create(array $in) : string
    {
        return $this->editor($in);
    }

    public function read(array $in) : string
    {
        $buf = '';
        foreach ($in as $row) {
            extract($row);
            $buf .= '
                <tr>
                  <td class="nowrap">
                    <a href="?o=news&m=read&i=' . $id . '" title="Show item">
                      <strong>' . $title . '</strong>
                    </a>
                  </td>
                  <td class="text-center nowrap bg-primary text-white w200" rowspan="2">
                    <small>
                      by <b>' . $author . '</b><br>
                      <i>' . util::now($updated) . '</i>
                    </small>
                  </td>
                </tr>
                <tr>
                  <td><p>' . nl2br($content) . '</p></td>
                </tr>';
        }

        return '
          <h3 class="min600">
            <a href="?o=news&m=create" title="Add news item">
              <i class="fa fa-newspaper-o fa-fw"></i> News
              <small>
                <i class="fa fa-plus-circle fa-fw"></i>
              </small>
            </a>
          </h3>
          <div class="table-responsive">
            <table class="table table-bordered min600">
              <tbody>' . $buf . '
              </tbody>
            </table>
          </div>';
    }

    public function read_one(array $ary) : string
    {
        extract($ary);

        return '
          <h3 class="w30">
            <a href="?o=news&m=read&i=0">
              <i class="fa fa-newspaper-o fa-fw"></i> ' . $title . '
            </a>
          </h3>
          <div class="table-responsive">
            <table class="table w30">
              <tbody>
                <tr>
                  <td>' . nl2br($content) . '</td>
                  <td class="text-center nowrap w200">
                    <small>
                      by <b>' . $author . '</b><br>
                      <i>' . util::now($updated) . '</i>
                    </small>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-12 text-right">
              <div class="btn-group">
                <a class="btn btn-secondary" href="?o=news&m=read&i=0">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
                <a class="btn btn-primary" href="?o=news&m=update&i=' . $id . '">Update</a>
              </div>
            </div>
          </div>';
    }

    public function update(array $in) : string
    {
        return $this->editor($in);
    }

    private function editor(array $ary) : string
    {
        extract($ary);
        $itemid = $this->g->in['m'] === 'create' ? 0 : $id;
        $header = $this->g->in['m'] === 'create' ? 'Add News' : 'Update News';
        $submit = $this->g->in['m'] === 'create' ? '
                <a class="btn btn-secondary" href="?o=news&m=read&i=0">&laquo; Back</a>
                <button type="submit" name="i" value="0" class="btn btn-primary">Add This Item</button>' : '
                <a class="btn btn-secondary" href="?o=news&m=read&i=' . $id . '">&laquo; Back</a>
                <a class="btn btn-danger" href="?o=news&m=delete&i=' . $id . '" title="Remove this item" onClick="javascript: return confirm(\'Are you sure you want to remove ' . $title . '?\')">Remove</a>
                <button type="submit" name="i" value="' . $id . '" class="btn btn-primary">Update</button>';

        return '
          <h3 class="w30">
            <a href="?o=news&m=read&i=' . $itemid . '">
              <i class="fa fa-newspaper-o fa-fw"></i> ' . $header . '
            </a>
          </h3>
          <form method="post" action="' . $this->g->self . '">
            <input type="hidden" name="o" value="' . $this->g->in['o'] . '">
            <input type="hidden" name="m" value="' . $this->g->in['m'] . '">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" id="title" name="title" value="' . $title . '" required>
                </div>
                <div class="form-group">
                  <label for="author">Author</label>
                  <input type="text" class="form-control" id="author" name="author" value="' . $author . '" required>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="content">Content</label>
                  <textarea class="form-control" id="content" name="content" rows="9" required>' . $content . '</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 text-right">
                <div class="btn-group">' . $submit . '
                </div>
              </div>
            </div>
          </form>';
    }
}

// lib/php/util.php 20150225 - 20170306

class Util
{
    public static function log(string $msg = '', string $lvl = 'danger') : array
    {
        if ($msg) {
            if (strpos($msg, ':')) list($lvl, $msg) = explode(':', $msg);
            $_SESSION['l'] = $lvl . ':' . $msg;
        } elseif (isset($_SESSION['l']) and $_SESSION['l']) {
            $l = $_SESSION['l']; $_SESSION['l'] = '';
            return explode(':', $l);
        }
        return ['', ''];
    }

    public static function esc(array $in) : array
    {
        foreach ($in as $k => $v)
            $in[$k] = isset($_REQUEST[$k])
                ? htmlentities(trim($_REQUEST[$k]), ENT_QUOTES, 'UTF-8') : $v;
        return $in;
    }

    public static function ses(string $k, $v) : string
    {
        return (string) $_SESSION[$k] =
            (isset($_REQUEST[$k]) && isset($_SESSION[$k]) && ($_REQUEST[$k] !== $_SESSION[$k]))
                ? $_REQUEST[$k] : $_SESSION[$k] ?? $v;
    }

    public static function cfg($g) : void
    {
        if (file_exists($g->file))
           foreach(include $g->file as $k => $v)
               $g->$k = array_merge($g->$k, $v);
    }

    public static function now($date1, $date2 = null)
    {
        if (!is_numeric($date1)) $date1 = strtotime($date1);
        if ($date2 and !is_numeric($date2)) $date2 = strtotime($date2);
        $date2 = $date2 ?? time();
        $diff = abs($date1 - $date2);
        if ($diff < 10) return ' just now';

        $blocks = [
            ['k' => 'year', 'v' => 31536000],
            ['k' => 'month','v' => 2678400],
            ['k' => 'week', 'v' => 604800],
            ['k' => 'day',  'v' => 86400],
            ['k' => 'hour', 'v' => 3600],
            ['k' => 'min',  'v' => 60],
            ['k' => 'sec',  'v' => 1],
        ];
        $levels = 2;
        $current_level = 1;
        $result = [];

        foreach ($blocks as $block) {
            if ($current_level > $levels) {
                break;
            }
            if ($diff / $block['v'] >= 1) {
                $amount = floor($diff / $block['v']);
                $plural = ($amount > 1) ? 's' : '';
                $result[] = $amount . ' ' . $block['k'] . $plural;
                $diff -= $amount * $block['v'];
                ++$current_level;
            }
        }
        return implode(' ', $result) . ' ago';
    }

}

// lib/php/plugin.php 20150101 - 20170305

class Plugin
{
    protected
    $buf = '',
    $tbl = '',
    $in  = [];

    public function __construct(Theme $t)
    {
        $this->t    = $t;
        $this->g    = $t->g;
        $this->in = util::esc($this->in);
        if ($this->tbl) {
            if (is_null(db::$dbh))
                db::$dbh = new db($t->g->db);
            db::$tbl  = $this->tbl;
        }
        $this->buf .= $this->{$t->g->in['m']}();
    }

    public function __toString() : string
    {
        return $this->buf;
    }

    protected function create() : string
    {
        if ($_POST) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = date('Y-m-d H:i:s');
            $lid = db::create($this->in);
            util::log('Item number ' . $lid . ' created', 'success');
            return $this->read();
        } else return $this->t->create($this->in);
    }

    protected function read() : string
    {
        return $this->g->in['i']
            ? $this->t->read_one($this->read_one())
            : $this->t->read($this->read_all());
    }

    protected function read_one() : array
    {
        return db::read('*', 'id', $this->g->in['i'], '', 'one');
    }

    protected function read_all() : array
    {
        return db::read('*', '', '', 'ORDER BY `updated` DESC');
    }

    protected function update() : string
    {
        if ($_POST) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            db::update($this->in, [['id', '=', $this->g->in['i']]]);
            util::log('Item number ' . $this->g->in['i'] . ' updated', 'success');
            $this->g->in['i'] = 0;
            return $this->read();
        } elseif ($this->g->in['i']) {
            return $this->t->update(db::read('*', 'id', $this->g->in['i'], '', 'one'));
        } else return 'Error updating item';
    }

    protected function delete() : string
    {
        if ($this->g->in['i']) {
            $res = db::delete([['id', '=', $this->g->in['i']]]);
            util::log('Item number ' . $this->g->in['i'] . ' removed', 'success');
            $this->g->in['i'] = 0;
            return $this->read();
        } else return 'Error deleting item';
    }
}

// lib/php/theme.php 20150101 - 20170305

class Theme
{
    private
    $buf = '',
    $in  = [];

    public function __construct($g)
    {
        $this->g = $g;
    }

    public function __toString() : string
    {
        return $this->buf;
    }

    public function log() : string
    {
        list($lvl, $msg) = util::log();
        return $msg ? '
      <p class="alert ' . $lvl . '">' . $msg . '</p>' : '';
    }

    public function nav1() : string
    {
        $o = '?o='.$this->g->in['o'];
        return '
      <nav>' . join('', array_map(function ($n) use ($o) {
            $c = $o === $n[1] ? ' class="active"' : '';
            return '
        <a' . $c . ' href="' . $n[1] . '">' . $n[0] . '</a>';
        }, $this->g->nav1)) . '
      </nav>';
    }

    public function head() : string
    {
        return '
    <header>
      <h1>
        <a href="' . $this->g->self . '">' . $this->g->out['head'] . '</a>
      </h1>' . $this->g->out['nav1'] . '
    </header>';
    }

    public function main() : string
    {
        return '
    <main>' . $this->g->out['log'] . $this->g->out['main'] . '
    </main>';
    }

    public function foot() : string
    {
        return '
    <footer class="text-center">
      <br>
      <p><em><small>' . $this->g->out['foot'] . '</small></em></p>
    </footer>';
    }

    public function html() : string
    {
        extract($this->g->out, EXTR_SKIP);
        return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . $doc . '</title>' . $css . '
  </head>
  <body>' . $head . $main . $foot . '
  </body>
</html>
';
    }

    public function create(array $in) : string
    {
        return 'Theme::create() not implemented';
    }

    public function read(array $in) : string
    {
        return 'Theme::read() not implemented';
    }

    public function read_one(array $in) : string
    {
        return 'Theme::read_one() not implemented';
    }

    public function read_all(array $in) : string
    {
        return 'Theme::read_all() not implemented';
    }

    public function update(array $in) : string
    {
        return 'Theme::update() not implemented';
    }

    public function delete(array $in) : string
    {
        return 'Theme::delete() not implemented';
    }

    private function editor(array $in) : string
    {
        return 'Theme::editor() not implemented';
    }
}

// lib/php/db.php 20150225 - 20170306

class Db extends \PDO
{
    public static $dbh = null;
    public static $tbl = null;

    public function __construct(array $dbcfg)
    {
        if (is_null(self::$dbh)) {
            extract($dbcfg);
            $dsn = $type === 'mysql'
                ? 'mysql:' . ($sock ? 'unix_socket='. $sock : 'host=' . $host . ';port=' . $port) . ';dbname=' . $name
                : 'sqlite:' . $path;
            $pass = file_exists($pass) ? include $pass : $pass;
            try {
                parent::__construct($dsn, $user, $pass, [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]);
            } catch(\PDOException $e) {
                die(__FILE__ . ' ' . __LINE__ . "<br>\n" . $e->getMessage());
            }
        }
    }

    public static function create(array $ary)
    {
        $fields = $values = '';
        foreach($ary as $k=>$v) {
            $fields .= "
                $k,";
            $values .= "
                :$k,";
        }
        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');

        $sql = "
 INSERT INTO `" . self::$tbl . "` ($fields)
 VALUES ($values)";

        try {
            $stm = self::$dbh->prepare($sql);
            self::bvs($stm, $ary);
            $res = $stm->execute();
            return self::$dbh->lastInsertId();
        } catch(\PDOException $e) {
            die(__FILE__ . ' ' . __LINE__ . "<br>\n" . $e->getMessage());
        }
    }

    public static function read(
        string $field,
        string $where = '',
        string $wval  = '',
        string $extra = '',
        string $type  = 'all')
    {
        $w = $where ? "
    WHERE $where = :wval" : '';
        $a = $wval ? ['wval' => $wval] : [];
        $sql = "
 SELECT $field
   FROM `" . self::$tbl . "`$w $extra";

        return self::qry($sql, $a, $type);
    }

    public static function update(array $set, array $where)
    {
        $set_str = '';
        foreach($set as $k=>$v) $set_str .= "
        $k = :$k,";
        $set_str = rtrim($set_str, ',');

        $where_str = '';
        $where_ary = [];
        foreach($where as $k=>$v) {
            $where_str .= " " . $v[0] . " " . $v[1] . " :" . $v[0];
            $where_ary[$v[0]] = $v[2] ;
        }
        $ary = array_merge($set, $where_ary);

        $sql = "
 UPDATE `" . self::$tbl . "` SET$set_str
  WHERE$where_str";

        try {
            $stm = self::$dbh->prepare($sql);
            self::bvs($stm, $ary);
            return $stm->execute();
        } catch(\PDOException $e) {
            die(__FILE__ . ' ' . __LINE__ . "<br>\n" . $e->getMessage());
        }
    }

    public static function delete(array $where)
    {
        $where_str = '';
        $where_ary = [];
        foreach($where as $k=>$v) {
            $where_str .= " " . $v[0] . " " . $v[1] . " :" . $v[0];
            $where_ary[$v[0]] = $v[2] ;
        }

        $sql = "
 DELETE FROM `" . self::$tbl . "`
  WHERE $where_str";

        try {
            $stm = self::$dbh->prepare($sql);
            self::bvs($stm, $where_ary);
            return $stm->execute();
        } catch(\PDOException $e) {
            die(__FILE__ . ' ' . __LINE__ . "<br>\n" . $e->getMessage());
        }
    }

    public static function qry(string $sql, array $ary = [], string $type = 'all')
    {
        try {
            if ($type !== 'all') $sql .= ' LIMIT 1';
            $stm = self::$dbh->prepare($sql);
            if ($ary) self::bvs($stm, $ary);
            if ($stm->execute()) {
                if ($type === 'all') $res = $stm->fetchAll();
                elseif ($type === 'one') $res = $stm->fetch();
                elseif ($type === 'col') $res = $stm->fetchColumn();
                $stm->closeCursor();
                return $res;
            } else return false;
        } catch(\PDOException $e) {
            die(__FILE__ . ' ' . __LINE__ . "<br>\n" . $e->getMessage());
        }
    }

    // bind value statement
    public static function bvs($stm, array $ary)
    {
        if (is_object($stm) && ($stm instanceof \PDOStatement)) {
            foreach($ary as $k => $v) {
                if (is_numeric($v))     $p = \PDO::PARAM_INT;
                elseif (is_bool($v))    $p = \PDO::PARAM_BOOL;
                elseif (is_null($v))    $p = \PDO::PARAM_NULL;
                elseif (is_string($v))  $p = \PDO::PARAM_STR;
                else $p = false;
                if ($p !== false) $stm->bindValue(":$k", $v, $p);
            }
        }
    }
}

// lib/php/init.php 20150101 - 20170305

class Init
{
    private $t = null;

    public function __construct($g)
    {
        session_start();
        //$_SESSION = []; // to reset session for testing
        util::cfg($g);
        $g->in = util::esc($g->in);
        $g->self = str_replace('index.php', '', $_SERVER['PHP_SELF']);

        util::ses('l', $g->in['l']);
        $t = util::ses('t', $g->in['t']);

        $t1 = 'themes_' . $t . '_' . $g->in['o'];
        $t2 = 'themes_' . $t . '_theme';

        $this->t = $thm = class_exists($t1) ? new $t1($g)
            : (class_exists($t2) ? new $t2($g) : new Theme($g));

        $p  = 'plugins_' . $g->in['o'];
        if (class_exists($p)) $g->out['main'] = (string) new $p($thm);
        else $g->out['main'] = "Error: no plugin object!";

        foreach ($g->out as $k => $v)
            $g->out[$k] = method_exists($thm, $k) ? $thm->$k() : $v;
    }

    public function __toString() : string
    {
        $g = $this->t->g;

        if ($g->in['x']) {
            $xhr = $g->out[$g->in['x']] ?? '';
            if ($xhr) return $xhr;
            header('Content-Type: application/json');
            return json_encode($g->out, JSON_PRETTY_PRINT);
        }
        return $this->t->html();
    }
}

// index.php 20150101 - 20170305

const DS  = DIRECTORY_SEPARATOR;
const INC = __DIR__ . DS . 'lib' . DS . 'php' . DS;

spl_autoload_register(function ($c) {
    $f = INC . str_replace(['\\', '_'], [DS, DS], strtolower($c)) . '.php';
    if (file_exists($f)) include $f;
    else error_log("!!! $f does not exist");
});

echo new Init(new class
{
    public
    $email      = 'markc@renta.net',
    $file       = 'lib' . DS . '.ht_conf.php', // settings override
    $self       = '',
    $in = [
        'i'     => 0,           // Item or ID
        'l'     => '',          // Log (message)
        'm'     => 'read',      // Method (action)
        'o'     => 'home',      // Object (content)
        't'     => 'bootstrap', // Theme
        'x'     => '',          // XHR (request)
    ],
    $out = [
        'doc'   => 'SPE::08',
        'css'   => '',
        'log'   => '',
        'nav1'  => '',
        'nav2'  => '',
        'head'  => 'Users',
        'main'  => 'Error: missing page!',
        'foot'  => 'Copyright (C) 2015-2017 Mark Constable (AGPL-3.0)',
    ],
    $db = [
        'host'  => '127.0.0.1', // DB site
        'name'  => 'sysadm',    // DB name
        'pass'  => 'lib' . DS . '.ht_pw.php', // MySQL password override
        'path'  => 'lib' . DS . '.ht_spe.sqlite', // SQLite DB
        'port'  => '3306',      // DB port
        'sock'  => '',          // '/run/mysqld/mysqld.sock',
        'type'  => 'sqlite',    // mysql | sqlite
        'user'  => 'sysadm',    // DB user
    ],
    $nav1 = [
        ['About',       '?o=about', 'fa fa-info-circle fa-fw'],
        ['Contact',     '?o=contact', 'fa fa-envelope fa-fw'],
        ['News',        '?o=news', 'fa fa-newspaper-o fa-fw'],
        ['Users',       '?o=users', 'fa fa-users fa-fw'],
    ],
    $nav2 = [
        ['None',        '?t=none'],
        ['Simple',      '?t=simple'],
        ['Bootstrap',   '?t=bootstrap'],
    ],
    $acl = [
        0 => 'Anonymous',
        1 => 'SuperAdmin',
        2 => 'Administrator',
        3 => 'User',
        4 => 'Suspended',
    ];
});

