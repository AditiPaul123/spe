<?php
// widgets.php 20151015 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Widgets
{
    public function a(
        string $href,
        string $label = '',
        string $class = '',
        string $extra = '') : string
    {
        $v = 'veto_a';
        if (method_exists($this, $v))
            extract($this->$v($href, $label, $class, $extra));

        $label = $label ?? $href;
        $class = $class ? ' class="'.$class.'"' : '';
        return '
        <a'.$class.' href="'.$href.'"'.$extra.'>'.$label.'</a>';
    }

    public function button(
        string $label,
        string $type = '',
        string $class = '',
        string $name = '',
        string $value = '',
        string $extra = '') : string
    {
        $v = 'veto_button';
        if (method_exists($this, $v))
            extract($this->$v($label, $type, $class, $name, $value, $extra));

        $class = $class ? ' class="'.$class.'"' : '';
        $type  = $type  ? ' type="'.$type.'"'   : '';
        $name  = $type  ? ' name="'.$name.'"'   : '';
        $value = $value ? ' value="'.$value.'"' : '';
        $extra = $extra ?? '';
        return '
          <button'.$class.$type.$name.$value.$extra.'>'.$label.'</button>';
    }

    public function email_contact_form() : string
    {
        $v = 'veto_email_contact_form';
        if (method_exists($this, $v)) return $this->$v();
        return '
      <form action="" method="post" onsubmit="return mailform(this);">
        <p>
          <label for="subject">Your Subject</label>
          <input type="text" id="subject" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,40}$">
        </p>
        <p>
          <label for="message">Your Message</label>
          <textarea type="text" rows= "5" id="message" maxlength="1024" minlength="5"></textarea>
        </p>
        <p>'.$this->button('Send', 'submit', 'primary').'
        </p>
      </form>';
    }

    public function notes_item($ary) : string
    {
        $v = 'veto_notes_item';
        if (method_exists($this, $v)) return $this->$v($ary);
        extract($ary);
        return '
      <hr>
      <table>
        <tr>
          <td><a href="?p=notes&a=read&i=' . $id . '">' . $title . '</a></td>
          <td style="text-align:right">
            <small>
              by <b>' . $author . '</b> - <i>' . util::now($updated) . '</i> -
              <a href="?p=notes&a=update&i=' . $id . '" title="Update">E</a>
              <a href="?p=notes&a=delete&i=' . $id . '" title="Delete" onClick="javascript: return confirm(\'Are you sure you want to remove '.$id.'?\')">X</a>
            </small>
          </td>
        </tr>
        <tr>
          <td colspan="2">' . nl2br($content) . '</td>
        </tr>
      </table>
      <br>';
    }

    public function notes_form($ary) : string
    {
        $v = 'veto_notes_form';
        if (method_exists($this, $v)) return $this->$v($ary);
        extract($ary);
        return '
      <form action="" method="POST">
        <p>
          <label for="title">Title</label>
          <input type="text" name="title" id="title" value="' . $title . '">
        </p>
        <p>
          <label for="author">Author</label>
          <input type="text" name="author" id="author" value="' . $author . '">
        </p>
        <p>
          <label for="content">Note</label>
          <textarea rows="7" name="content" id="content">' . $content . '</textarea>
        </p>
        <p>'.$this->button('Submit', 'submit', 'primary').'
        <input type="hidden" name="p" value="' . $this->g->in['p'] . '">
        <input type="hidden" name="a" value="' . $this->g->in['a'] . '">
        <input type="hidden" name="i" value="' . $this->g->in['i'] . '">
      </form>';
    }
}
