<?php
// notes.php 20151018 (C) 2015 Mark Constable <markc@renta.net> (AGPL-3.0)

declare(strict_types = 1);

class Notes
{
    const TABLE = 'notes';

    private $g  = null;
    private $t  = null;
    private $b  = '
    <h2>Notes</h2>
    <p>
This is a simple note system, you can
<a href="?p=notes&a=create" title="Create">create</a> a new note or
<a href="?p=notes&a=read" title="Read">read</a> them at your leisure.
    </p>';
    private $in = [
        'title'     => '',
        'author'    => '',
        'content'   => '',
        'updated'   => '',
        'created'   => '',
    ];

    public function __construct(View $t, $g)
    {
        $this->t  = $t;
        $this->g  = $g;
        db::$tbl  = self::TABLE;
        $this->in = util::esc($this->in);
        $this->b .= $this->{$g->in['a']}();
    }

    public function __toString() : string
    {
        return $this->b;
    }

    public function create()
    {
        if (count($_POST)) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = date('Y-m-d H:i:s');
            db::create($this->in);
            return $this->read();
        } else {
            $this->in['submit']  = 'Add new note';
            return $this->t->notes_form($this->in);
        }
    }

    public function read() : string
    {
        if ($this->g->in['i']) {
            return $this->t->notes_item(
                db::read('*', 'id', $this->g->in['i'], '', 'one')
            );
        } else {
            return $this->t->notes_list([
                'notes' => db::read('*', '', '', 'ORDER BY `updated` DESC')
            ]);
        }
    }

    public function update() : string
    {
        if (count($_POST)) {
            $this->in['updated'] = date('Y-m-d H:i:s');
            $this->in['created'] = db::read('created', 'id', $this->g->in['i'], '', 'col');
            db::update($this->in, [['id', '=', $this->g->in['i']]]);
            $this->g->in['i'] = 0;
            return $this->read();
        } elseif ($this->g->in['i']) {
            return $this->t->notes_form(array_merge(
                db::read('*', 'id', $this->g->in['i'], '', 'one'),
                ['submit' => 'Update note']
            ));
        } else return 'Error updating note';
    }

    public function delete() : string
    {
        if ($this->g->in['i']) {
            $res = db::delete([['id', '=', $this->g->in['i']]]);
            $this->g->in['i'] = 0;
            return $this->read();
        } else return 'Error deleting note';
    }
}
