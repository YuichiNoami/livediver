<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>
		<?php
			if (!isset($data_for_layout)) {
				$data_for_layout = [
					"url" => "https://livediver.net/",
					"description" => "誰もが自由にライブの情報を登録・編集できる！もっとライブに行きたくなる情報ポータルサイトLiveDiver",
				];
			}
		?>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $data_for_layout['description']; ?>">
	<meta name="author" content="CATCH THE BEAT">
	<meta name="keywords" content="ライブ,Live,ミュージシャン,バンド">
	<meta property="og:title" content="<?php echo $title_for_layout; ?>">
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo $data_for_layout['url']; ?>">
	<meta property="og:image" content="https://livediver.net/ico/LiveDiverLogo.png">
	<meta property="og:site_name" content="<?php echo $title_for_layout; ?>">
	<meta property="og:description" content="<?php echo $data_for_layout['description']; ?>">
	<meta property="fb:admins" content="100001714302441">
	<meta property="fb:app_id" content="195940900991708">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@yuichin925">
	<meta name="twitter:title" content="<?php echo $title_for_layout; ?>">
	<meta name="twitter:url" content="<?php echo $data_for_layout['url']; ?>">
	<meta property="twitter:image" content="https://livediver.net/ico/LiveDiverLogo.png">
	<meta name="twitter:description" content="<?php echo $data_for_layout['description']; ?>">
	<link rel="canonical" href="<?php echo $data_for_layout['url']; ?>">


	<!-- Le styles -->
	<?php echo $this->Html->css('bootstrap'); ?>
	<?php echo $this->Html->css('style'); ?>
	<style>
		body {
			padding-top: 60px;
			/* 60px to make the container go all the way to the bottom of the topbar */
		}
	</style>
	<?php echo $this->Html->css('bootstrap-responsive'); ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->

	<link rel="shortcut icon" href="/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">

	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>
	<?php echo $this->element('analytics'); ?>
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=360763824060398&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<?php echo $this->Html->link('LiveDiver', '/', array('class' => 'brand')); ?>
				<div class="nav-collapse collapse navbar-responsive-collapse">
					<ul class="nav pull-left">
						<li><?php echo $this->Html->link('イベント', '/events/'); ?></li>
						<li><?php echo $this->Html->link('アーティスト', '/artists/'); ?></li>
						<li><?php echo $this->Html->link('利用規約', '/licenses/'); ?></li>
					</ul>
					<ul class="nav pull-right">
						<?php if (isset($user)) { ?>
							<li><?php echo $this->Html->link('マイページ', '/users/'); ?></li>
							<li><?php echo $this->Html->link('ログアウト', '/users/logout'); ?></li>
						<?php } else { ?>
							<li><?php echo $this->Html->link('ログイン', '/users/login'); ?></li>
							<li><?php echo $this->Html->link('新規登録', '/users/register'); ?></li>
						<?php } ?>

					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">

		<?php echo $this->Session->flash(); ?>

		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="tweet">
			<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-text="<?php echo h($title_for_layout) ?>" data-url="<?php echo ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>">ツイート</a>
			<script>
				! function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0],
						p = /^http:/.test(d.location) ? 'http' : 'https';
					if (!d.getElementById(id)) {
						js = d.createElement(s);
						js.id = id;
						js.src = p + '://platform.twitter.com/widgets.js';
						fjs.parentNode.insertBefore(js, fjs);
					}
				}(document, 'script', 'twitter-wjs');
			</script>
		</div>
		<div class="fb-like" data-href="<?php echo ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
		<div id="footer" class="well">
			<small>
				Copyright &copy; 2014-<?php print(date("Y")); ?> <a href="https://catch-the-beat.com/">CATCH THE BEAT</a> &amp; The Tollow All Rights Reserved.
			</small>
		</div>

	</div> <!-- /container -->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->Html->script('resize'); ?>
	<?php echo $this->fetch('script'); ?>

</body>

</html>