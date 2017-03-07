<?php
// lib/php/themes/bootstrap/theme.php 20150101 - 20170305
// Copyright (C) 2015-2017 Mark Constable <markc@renta.net> (AGPL-3.0)

class Themes_Bootstrap_Theme extends Theme
{
    public function css() : string
    {
error_log(__METHOD__);

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
error_log(__METHOD__);

        list($lvl, $msg) = util::log();
        return $msg ? '
      <div class="alert alert-' . $lvl . '">' . $msg . '
      </div>' : '';
    }

    public function head() : string
    {
error_log(__METHOD__);

        return '
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="' . $this->g->self . '" title="Home Page">
          <b><i class="fa fa-home"></i> ' . $this->g->out['head'] . '</b>
        </a>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">' . $this->g->out['nav1'] . '
          </ul>
          <ul class="navbar-nav">'  . $this->g->out['nav2'] . '
          </ul>
        </div>
      </div>
    </nav>';
    }

    public function nav1(array $a = []) : string
    {
error_log(__METHOD__);

        $a = isset($a[0]) ? $a : util::which_usr($this->g->nav1);
        $o = '?o=' . $this->g->in['o'];
        $t = '?t=' . $_SESSION['t'];
        return join('', array_map(function ($n) use ($o, $t) {
            if (is_array($n[1])) return $this->nav_dropdown($n);
            $c = $o === $n[1] || $t === $n[1] ? ' active' : '';
            $i = isset($n[2]) ? '<i class="' . $n[2] . '"></i> ' : '';
            return '
          <li class="nav-item' . $c . '">
            <a class="nav-link" href="' . $n[1] . '">' . $i . $n[0] . '</a>
          </li>';
        }, $a));
    }

    public function nav2() : string
    {
error_log(__METHOD__);

        return $this->nav_dropdown(['Theme', $this->g->nav2, 'fa fa-th fa-fw']);
    }

    public function nav_dropdown(array $a = []) : string
    {
error_log(__METHOD__);

        $o = '?o=' . $this->g->in['o'];
        $i = isset($a[2]) ? '<i class="' . $a[2] . '"></i> ' : '';
        return '
          <li class="nav-item dropdown pull-right">
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
error_log(__METHOD__);

        return '
    <main class="container">
      <div class="row">
        <div class="col-12">' . $this->g->out['log'] . $this->g->out['main'] . '
        </div>
      </div>
    </main>';
    }
}

?>
