      <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="row">
        <div class="navbar-header col-sm-10 col-xs-12">
          <a class="navbar-brand" href="#">
              <img src="static/images/logo.png" alt="Logo" >
          </a>
        </div>
        <?php
           if(isset($_SESSION['isConnected']) && $_SESSION['isConnected'] ==true){
          ?>
          <div id="navbar" class="navbar-collapse col-sm-2 col-xs-12">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bonjour <?php echo strtoupper($_SESSION['login']); ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/">Log Out</a></li>
                  </ul>
                </li>
              </ul>
          </div><!--/.navbar-collapse -->
            <?php
               }
            ?>
        </div>
      </div>
    </nav>