<?php
$userobj = new User();
$udata = $userobj->getUserData($_SESSION['uid']);
?>
<div class="row">
	<div class="col-sm-12">
	<form action="?p=user&action=UpdateUser" method=POST class="form_user_info">	
		<fieldset>
			<legend>Omistajan tiedot</legend>
			<p><label>Käyttäjätunnus </label><input type="text" value="<?= $udata['user_account'] ?>" name="user_login_name" required></p>
			<p><label>Koko nimi</label><input type="text" value="<?= $udata['user_real_name'] ?>" name="user_real_name" required></p>
			<p><label>Salasana</label><input type="text" value="<?= $udata['user_pwd'] ?>" name="user_pwd"></p>
			<p><label>Kotiosoite</label><input type="text" value="<?= $udata['user_address'] ?>" name="user_address" required></p>
			<p><label>Laskutusosoite</label><input type="text" value="<?= $udata['user_billing_address'] ?>" name="user_billing_address" required></p>
			<p><label>Puhelinnumero</label><input type="text" value="<?= $udata['user_phone_number'] ?>" name="user_phone_number" required></p>
		</fieldset>
		<fieldset>
			<legend>Kiinteistön tiedot</legend>
			<p><label>Kiinteistön tyyppi</label><input type="text" value="<?= $udata['user_property_type'] ?>" name="user_property_type"></p>
			<p><label>Kiinteistön koko m²</label><input type="text" value="<?= $udata['user_property_size'] ?>" name="user_property_size"></p>
			<p><label>Tontin koko m²</label><input type="text" value="<?= $udata['user_plot_size'] ?>" name="user_plot_size"></p>
			<input type="submit" value="Päivitä tiedot">
		</fieldset>	
	</form>
	</div>
</div>	