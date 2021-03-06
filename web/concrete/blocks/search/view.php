<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php if (isset($error)) { ?>
	<?php echo $error?><br/><br/>
<?php } ?>

<form action="<?php echo $this->url( $resultTargetURL )?>" method="get" class="ccm-search-block-form">

	<?php if( strlen($title)>0){ ?><h3><?php echo $title?></h3><?php } ?>
	
	<?php if(strlen($query)==0){ ?>
	<input name="search_paths[]" type="hidden" value="<?php echo htmlentities($baseSearchPath, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php } else if (is_array($_REQUEST['search_paths'])) { 
		foreach($_REQUEST['search_paths'] as $search_path){ ?>
			<input name="search_paths[]" type="hidden" value="<?php echo htmlentities($search_path, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php  }
	} ?>
	
	<input name="query" type="text" value="<?php echo htmlentities($query, ENT_COMPAT, APP_CHARSET)?>" class="ccm-search-block-text" />
	
	<input name="submit" type="submit" value="<?php echo $buttonText?>" class="ccm-search-block-submit" />

<?php 
$tt = Loader::helper('text');
if ($do_search) {
	if(empty($results)){ ?>
		<h4 style="margin-top:32px"><?php echo t('There were no results found. Please try another keyword or phrase.')?></h4>	
	<?php }else{ ?>
		<div id="searchResults">
		<?php foreach($results as $r) { 
			$currentPageBody = $this->controller->highlightedExtendedMarkup($r->getBodyContent(), $query);?>
			<div class="searchResult">
				<h3><a href="<?php echo $r->getPath()?>"><?php echo $r->getName()?></a></h3>
				<p>
					<?php if ($r->getDescription()) { ?>
						<?php  echo $this->controller->highlightedMarkup($tt->shortText($r->getDescription()),$query)?><br/>
					<?php } ?>
					<?php echo $currentPageBody; ?>
					<a href="<?php  echo $r->getPath(); ?>" class="pageLink"><?php  echo $this->controller->highlightedMarkup($r->getPath(),$query)?></a>
				</p>
			</div>
		<?php 	}//foreach search result ?>
		</div>
		
		<?php
		if($paginator && strlen($paginator->getPages())>0){ ?>	
		<div class="ccm-pagination">	
			 <span class="ccm-page-left"><?php echo $paginator->getPrevious()?></span>
			 <?php echo $paginator->getPages()?>
			 <span class="ccm-page-right"><?php echo $paginator->getNext()?></span>
		</div>	
		<?php } ?>

	<?php				
	} //results found
} 
?>

</form>