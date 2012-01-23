<?php

/**
 * 
 * @todo remove category on search as we dont need it 
 * This class will be helping to include search functionality 
 * @author Pascal Maniraho
 *
 */
class Core_View_Helper_Search extends Core_View_Helper_Base{
	
	
	public function search($options = array() ){
		return "<div id='search'>

		<!-- Search form using the expose effect, remove the class if you don't wish to have it -->
		<form class='expose' action='index' method='get' name='search'>

			<h3>Search Property</h3>

			<!-- Start of a row -->
			<div class='row'>
				<label>Location</label>
			</div>

			<div class='row'>
				<div class='box large border_light'>
					<select class='large' name='location'>
						<optgroup label='England'>
							<option>Anywhere, I don't mind</option>
							<option>Bedfordshire</option>
							<option>Berkshire</option>
							<option>Bristol</option>
						</optgroup>
						<optgroup label='Wales'>
							<option>Anglesey</option>
							<option>Brecknockshire</option>
						</optgroup>
					</select>
				</div>
			</div>

			<div class='row'>
				<label>Bedrooms</label> <label>Buying Price</label> <label>Renting
					Price</label>
			</div>

			<div class='row'>
				<div class='box small border_light'>
					<select class='small' name='beds'>
						<option value='any'>Any</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5+</option>
					</select>
				</div>
				<div class='box medium border_light'>
					<select class='medium' name='min'>
						<option value='any'>Any</option>
						<option value='100000'>&pound;100,000+</option>
						<option value='200000'>&pound;200,000+</option>
						<option value='300000'>&pound;300,000+</option>
						<option value='400000'>&pound;400,000+</option>
						<option value='500000'>&pound;500,000+</option>
					</select>
				</div>

				<div class='box medium border_light'>
					<select class='medium' name='max'>
						<option value='any'>Any</option>
						<option value='100000'>&pound;400+</option>
						<option value='200000'>&pound;600+</option>
						<option value='300000'>&pound;800+</option>
						<option value='400000'>&pound;1000+</option>
					</select>
				</div>
			</div>

			<div class='row'>
				<label>Renting or Buying</label>
			</div>

			<div class='row'>
				<div class='box medium2 border_light'>
					<select class='medium2' name='date'>
						<option value='any'>Any, I don't mind</option>
						<option value='rent'>I'm looking to rent</option>
						<option value='buy'>I'm looking to buy</option>
					</select>
				</div>

				<div class='left'>
					<input id='submit' type='image' src='/assets/images/search_btn.jpg'
						onmouseover='this.src=\'/assets/images/search_btn_hover.jpg\''
						onmouseout='this.src=\'/assets/images/search_btn.jpg\'' />
				</div>
			</div>
			<div class='clear'></div>
		</form>
	</div>";
	}
	
	
	
	
	
}


?>