<div class="row">
	<div class="col-sm-12">
		<h3>Omat aktiiviset työtilaukset</h3>
		<table class="table table-striped">
		<thead>
			<th>Tilauspvm</th>
			<th>Talotyyppi</th>
			<th>Kuvaus</th>
			<th>Tila</th>
			<th>Aloituspvm</th>
			<th>Valmistumispvm</th>
			<th>Kustannusarvio</th>
			<th><i class="fa fa-edit"></i></th>
			<th><i class="fa fa-trash"></i></th>
		</thead>	
		<?php 
		$order_list = new Order();
		$order_list->getAll($_SESSION['uid']);
		?>
		</table>
		<div class="form_new_request">
		<h3>Lisää uusi työtilaus</h3>
		<p>Sinun ei tarvitse täyttää kuin "kuvaus työstä"-kenttä, muut tietosi työtilaukseen haetaan automaattisesti.</p>
		<form action="?action=NewOrder" id="new_order" method=POST>	
			<label>Kuvaus työstä</label>
			<input type="text" name="order_description" required>
			<input type="hidden" name="user_id" value="<?= $_SESSION['uid'] ?>">
			<input type="submit" form="new_order" value="Tallenna">
		</form>	
		</div>	
	</div>
</div>	
<div class="row">
	<div class="col-sm-12">
		<h3>Omat tarjouspyynnöt</h3>
		<table class="table table-striped">
		<thead>
			<th>Tilauspvm</th>
			<th>Talotyyppi</th>
			<th>Kuvaus</th>
			<th>Tila</th>
			<th>Kustannusarvio</th>
			<th><i class="fa fa-edit"></i></th>
			<th><i class="fa fa-trash"></i></th>
		</thead>
			
		<?php 
		$request_list = new Request();
		$request_list->getAll($_SESSION['uid']);
		?>
			
		</table>
		<div class="form_new_request">
		<h3>Lisää uusi tarjouspyyntö</h3>
		<p>Sinun ei tarvitse täyttää kuin "kuvaus työstä"-kenttä, muut tietosi tarjouspyyntöön haetaan automaattisesti.</p>	
		<form action="?action=NewRequest" id="new_request" method=POST>
			<label>Kuvaus työstä</label>
			<input type="text" name="request_description" required>
			<input type="hidden" name="user_id" value="<?= $_SESSION['uid'] ?>">
			<input type="submit" form="new_request" value="Tallenna">
		</form>	
		</div>			
	</div>
</div>