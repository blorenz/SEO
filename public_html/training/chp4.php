<?php
include('../../include/session.php');
?>
<head>
<title>Online Help Document</title>

<style type="text/css">
<!--
.MsoNormal {font-size:12.0pt;
	font-family:"Times New Roman";}
.style2 {font-size: 16pt; font-family: "Times New Roman"; }
.style3 {font-size: 16pt}
.style4 {font-size: 14pt}
.style8 {	font-size: 12pt;
	font-family: Arial, Helvetica, sans-serif;
	color: #FF0000;
}
-->
</style>
</head>

<body>

  <p class="MsoNormal"><b><span style="font-size: 18pt;"><i>Chapter 4 - Buying</i></span></b></p>
  <p class="MsoNormal style3"><a name="Chp4_Searching"><span style="">Searching</span></a></p>
      <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="5">
      <tr>
       <td class="normal" valign="top" nowrap>
			<select>
				<option value="all" selected>All categories</option>
								<option value="11">Aircraft</option>
								<option value="12">ATVs</option>
								<option value="13">Commercial Vehicles</option>
								<option value="14">Marine</option>

								<option value="15">Motorcycles</option>
								<option value="16">Passenger Vehicles</option>
								<option value="17">Race Cars</option>
								<option value="18">RVs</option>
								<option value="19">Trailers and Campers</option>
		 </select>

			<input type="submit" value="Advanced Search">
       </td>
       <td valign="top">
				<input class="normal" type="text" value="" size="35">
				<input class="header" type="submit" value="Search">
       </td>
	   </tr>
</table><i>fig 4.1</i>
  <p class="MsoNormal style4"><span style="">Standard Search</span></p>
  <p class="MsoNormal">The standard search uses the textbox and the Search button.
    You can type in one or more keywords to search by. Figure 4.2 below shows
    the standard search part of the search bar. </p>
  <p class="MsoNormal">
  				<input class="normal" type="text" value="" size="35">
				<input class="header" type="submit" value="Search">&nbsp;&nbsp;<i>fig 4.2</i></p>
  <p class="MsoNormal style4"><span style="">Advanced Search</span></p>
  <p class="MsoNormal">With the advanced search,
      you can search one or multiple items in a category. You can get to the
      advanced search  by clicking the Advanced
      Search button, or click the link when it shows up after doing a standard
      search. You will see the list of categories shown in figure 4.3 below if
      you keep the category set to All Categories. If you choose a specific category,
    such as passenger vehicles, then you will see figure 4.4 below. </p>
  <p class="MsoNormal"><img src="images/categories.gif" width="213" height="195"><i>fig
      4.3</i></p>
  <p class="MsoNormal style4"><span class="MsoNormal">Assuming you see figure
      4.3, once you click on the category you would like to search, you may choose
      one or multiple items from the subcategories below it. We clicked on Passenger
      Vehicles, so the checkboxes shown will be the makes of the passenger vehicles.
      Below is an example of what you will see. You can check the Honda and
      Toyota box to search for both Toyota and Honda vehicles. </span></p>
  <p class="header" align="center"><br><u>Select All that Apply</u><br>				
  <table align="center" border="0" cellspacing="5" cellpadding="5">				
		<form action="/auction/advsearch.php" method="POST"><input type="hidden" value="16">				
		<tr><td valign="top" align="left" class="normal" width="175">				
				<input type="checkbox">Acura<br>
				<input type="checkbox">Alfa Romeo<br>
				<input type="checkbox">AMC<br>
				<input type="checkbox">Aston Martin<br>
				<input type="checkbox">Audi<br>		
				<input type="checkbox">Austin<br>
				<input type="checkbox">Austin Healey<br>		
				<input type="checkbox">Bentley<br>		
				<input type="checkbox">BMW<br>						
				<input type="checkbox">Buick<br>
				<input type="checkbox">Cadillac<br>
				<input type="checkbox">Chevrolet<br>
				<input type="checkbox">Chrysler<br>
				<input type="checkbox">Citroen<br>
				<input type="checkbox">Cord<br>
				<input type="checkbox">Daewoo<br>
				<input type="checkbox">Datsun<br>		
				<input type="checkbox">DeLorean<br>		
				<input type="checkbox">DeSoto<br>		
				<input type="checkbox">Dodge<br>		
						
					</td><td valign="top" align="left" class="normal" width="175">					
						
				<input type="checkbox">Eagle<br>		
				<input type="checkbox">Edsel<br>		
				<input type="checkbox">Ferrari<br>		
				<input type="checkbox">Fiat<br>		
				<input type="checkbox">Ford<br>		
				<input type="checkbox">Geo<br>		
				<input type="checkbox">GMC<br>		
				<input type="checkbox" checked>Honda<br>		
				<input type="checkbox">Hummer<br>		
				<input type="checkbox">Hyundai<br>		
				<input type="checkbox">Infiniti<br>		
				<input type="checkbox">International Harvester<br>		
				<input type="checkbox">Isuzu<br>		
				<input type="checkbox">Jaguar<br>		
				<input type="checkbox">Jeep<br>		
				<input type="checkbox">Kia<br>		
				<input type="checkbox">Lamborghini<br>		
				<input type="checkbox">Lancia<br>		
				<input type="checkbox">Land Rover<br>		
				<input type="checkbox">Lexus<br>		
						
					</td><td valign="top" align="left" class="normal" width="175">					
						
				<input type="checkbox">Lincoln<br>		
				<input type="checkbox">Lotus<br>		
				<input type="checkbox">Maserati<br>		
				<input type="checkbox">Mazda<br>		
				<input type="checkbox">Mercedes-Benz<br>		
				<input type="checkbox">Mercury<br>		
				<input type="checkbox">MG<br>		
				<input type="checkbox">Mini<br>		
				<input type="checkbox">Mitsubishi<br>		
				<input type="checkbox">Nash<br>		
				<input type="checkbox">Nissan<br>		
				<input type="checkbox">Oldsmobile<br>		
				<input type="checkbox">Opel<br>		
				<input type="checkbox">Other<br>		
				<input type="checkbox">Packard<br>		
				<input type="checkbox">Peugeot<br>		
				<input type="checkbox">Plymouth<br>		
				<input type="checkbox">Pontiac<br>		
				<input type="checkbox">Porsche<br>		
				<input type="checkbox">Renault<br>		
						
					</td><td valign="top" align="left" class="normal" width="175">	
						
				<input type="checkbox">Replica/Kit Makes<br>		
				<input type="checkbox">Rolls-Royce<br>		
				<input type="checkbox">Saab<br>		
				<input type="checkbox">Saturn<br>		
				<input type="checkbox">Scion<br>		
				<input type="checkbox">Shelby<br>		
				<input type="checkbox">Studebaker<br>		
				<input type="checkbox">Subaru<br>		
				<input type="checkbox">Suzuki<br>		
				<input type="checkbox" checked>Toyota<br>		
				<input type="checkbox">Triumph<br>		
				<input type="checkbox">Volkswagen<br>		
				<input type="checkbox">Volvo<br>		
				<input type="checkbox">Willys<br>		
						
						
		</td></tr><tr><td align="center" colspan="99"><input type="submit" value="Continue >>>" /></td></tr></form></table><i>fig 4.4</i>
  <p class="MsoNormal">When you press continue,
      you will see the subcategories, if any, for the categories you chose using
      the checkboxes above. In this case, you will see the Toyota and Honda models.
      As shown below, the models of the cars are shown at the top of the page.
      Below that you can chose other options to search by. All is selected by
      default. If you do not change this, then all the Hondas and/or Toyotas
      will searched. Below that are more specifications to search by. These are
      customized to the category that you pick. However, the map
      at the bottom is present in all searches.</p>
  <p class="header" align="center"><u>Select All that Apply</u>
		<table width="574" border="0" align="center" cellpadding="5" cellspacing="5">					
		<input type="hidden" value="16">				
			<tr>			
			<td width="175" height="295" align="left" valign="top" class="normal"><u><b>Honda</b></u><br>		
			<input type="checkbox" value="1338" checked>All<br>
			<input type="checkbox" value="1339">Accord<br>
			<input type="checkbox" value="1340">Civic<br>		
			<input type="checkbox" value="1341">CR-V<br>
			<input type="checkbox" value="1342">CRX<br>
			<input type="checkbox" value="1343">Del Sol<br>
			<input type="checkbox" value="1344">Element<br>
			<input type="checkbox" value="1345">Insight<br>
			<input type="checkbox" value="1346">Odyssey<br>
			<input type="checkbox" value="1347">Other<br>
			<input type="checkbox" value="1348">Passport<br>
			<input type="checkbox" value="1349">Pilot<br>
			<input type="checkbox" value="1350">Prelude<br>
			<input type="checkbox" value="1351">S2000		</td>			
			<td valign="top" align="left" class="normal" width="175"><u><b>Toyota</b></u><br>
			<input type="checkbox" value="1562" checked>All<br>
			<input type="checkbox" value="1563">4Runner<br>
			<input type="checkbox" value="1564">Avalon<br>
			<input type="checkbox" value="1565">Camry<br>
			<input type="checkbox" value="1566">Celica<br>
			<input type="checkbox" value="1567">Corolla<br>
			<input type="checkbox" value="1568">Highlander<br>
			<input type="checkbox" value="1569">Land Cruiser<br>
			<input type="checkbox" value="1570">Matrix<br>
			<input type="checkbox" value="1571">MR2<br>
			<input type="checkbox" value="1572">Other<br>
			<input type="checkbox" value="1573">Paseo<br>
			<input type="checkbox" value="1574">Previa<br>
			<input type="checkbox" value="1575">Prius		
			</td><td valign="top" align="left" class="normal" width="175"><p><br>
			    <input type="checkbox" value="1576">
			    RAV4<br>
                <input type="checkbox" value="1577">
                Sequoia<br>
                <input type="checkbox" value="1578">
                Sienna<br>
                <input type="checkbox" value="1579">
                Solara<br>
                <input type="checkbox" value="1580">
                Supra<br>
                <input type="checkbox" value="1581">
                Tacoma<br>
                <input type="checkbox" value="1582">
                Tercel<br>
		        <input type="checkbox" value="1583">
		      Tundra<br>
			  </p></td>		
			</tr>
	</table>				
        <table align="center" border="0" cellspacing="10" cellpadding="5">
          <tr>
            <td colspan="4" class="header" align="center" valign="top"><br>
                <u><b>Check the Following that Apply</b></u><br>
          &nbsp;</td>
          </tr>
          <tr>
            <td valign="top" align="right" class="header">Year:</td>

            <td colspan="3" class="normal"><select name="year_start">
                <option value="1900">1900</option><option value="1901">1901</option><option value="1902">1902</option><option value="1903">1903</option><option value="1904">1904</option><option value="1905">1905</option><option value="1906">1906</option><option value="1907">1907</option><option value="1908">1908</option><option value="1909">1909</option><option value="1910">1910</option><option value="1911">1911</option><option value="1912">1912</option><option value="1913">1913</option><option value="1914">1914</option><option value="1915">1915</option><option value="1916">1916</option><option value="1917">1917</option><option value="1918">1918</option><option value="1919">1919</option><option value="1920">1920</option><option value="1921">1921</option><option value="1922">1922</option><option value="1923">1923</option><option value="1924">1924</option><option value="1925">1925</option><option value="1926">1926</option><option value="1927">1927</option><option value="1928">1928</option><option value="1929">1929</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option>              </select>

      to
      <select name="year_end">
        <option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option>    </select></td>

          </tr>
                    <tr>
            <td valign="top" align="right" class="header">Miles:</td>
            <td colspan="3" class="normal">Less Than
                <input type="text" value="" size="15" /></td>
          </tr>
                                                                      <tr>
            <td valign="top" align="right" class="header">Body:</td>

            <td valign="top" class="normal">
              <input type="checkbox" value='Convertible'>
              Convertible<br>
              <input type="checkbox" value='Coupe'>
              Coupe<br>
              <input type="checkbox" value='Hatchback'>
              Hatchback<br>

              <input type="checkbox" value='Sedan'>
              Sedan<br>
              <input type="checkbox" value='Sport Utility'>
              Sport Utility<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" value='Truck'>
              Truck<br>

              <input type="checkbox" value='Van'>
              Van<br>
              <input type="checkbox" value='Wagon'>
              Wagon<br>
              <input type="checkbox" value='Other'>
              Other<br>
            </td>

          </tr>
                                                  <tr>
            <td valign="top" align="right" class="header">Engine:</td>
            <td valign="top" class="normal">
              <input type="checkbox" value='1 Cylinders'>
              1 Cylinder<br>
              <input type="checkbox" value='2 Cylinders'>
              2 Cylinders<br>

              <input type="checkbox" value='3 Cylinders'>
              3 Cylinders<br>
              <input type="checkbox" value='4 Cylinders'>
              4 Cylinders<br>
              <input type="checkbox" value='5 Cylinders'>
              5 Cylinders<br>
              <input type="checkbox" value='6 Cylinders'>

              6 Cylinders
            </td>
            <td valign="top" colspan="2" class="normal">
			  <input type="checkbox" value='8 Cylinders'>
              8 Cylinders<br>
              <input type="checkbox" value='10 Cylinders'>
              10 Cylinders<br>

              <input type="checkbox" value='12 Cylinders'>
              12 Cylinders<br>
              <input type="checkbox" value='Rotary'>
              Rotary<br>
              <input type="checkbox" value='Electric'>
              Electric<br>
              <input type="checkbox" value='Other'>

              Other
            </td>
          </tr>
                                                                      <tr>
            <td valign="top" align="right" class="header">Fuel Type:</td>
            <td valign="top" class="normal">
              <input type="checkbox" value='Gas'>
              Gas<br>

              <input type="checkbox" value='diesel'>
              diesel<br>
              <input type="checkbox" value='Hybrid'>
              Hybrid<br>
              <input type="checkbox" value='Electric'>
              Electric<br>
              <input type="checkbox" value='Natural Gas'>

              Natural Gas<br>
            </td>
            <td valign="top" colspan="2" class="normal">
              <input type="checkbox" value='Aviation'>
              Aviation<br>
              <input type="checkbox" value='Hydrogen'>
              Hydrogen<br>

              <input type="checkbox" value='Wind'>
              Wind<br>
              <input type="checkbox" value='Other'>
              Other<br>
            </td>
          </tr>
                                        <tr>
            <td valign="top" align="right" class="header">Drive Train:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" value='Front WD'>
              Front WD<br>
              <input type="checkbox" value='Rear WD'>
              Rear WD<br>
              <input type="checkbox" value='4WD'>
              4WD<br>

              <input type="checkbox" value='All WD'>
              All WD<br>
              <input type="checkbox" value='Other'>
              Other</td>
          </tr>
                                        <tr>
            <td valign="top" align="right" class="header">Transmission:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" value='Automatic'>
              Automatic<br>
              <input type="checkbox" value='Manual'>
              Manual<br>
              <input type="checkbox" value='Semi-Automatic'>
              Semi-Automatic<br>

              <input type="checkbox" value='Other'>
              Other</td>
          </tr>
                                                                      <tr>
            <td valign="top" align="right" class="header">Seat Surface:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" value='Leather'>Leather<br>

              <input type="checkbox" value='Cloth'>Cloth<br>
              <input type="checkbox" value='Vinyl'>Vinyl<br>
              <input type="checkbox" value='Other'>Other</td>
          </tr>
                              <tr>
            <td valign="top" align="right" class="header">Interior Color:</td>

            <td valign="top" class="normal">
              <input type="checkbox" value='Beige'>
              Beige<br>
              <input type="checkbox" value='Black'>
              Black<br>
              <input type="checkbox" value='Blue'>
              Blue<br>

              <input type="checkbox" value='Brown'>
              Brown<br>
              <input type="checkbox" value='Burgundy'>
              Burgundy<br>
              <input type="checkbox" value='Champagne'>
              Champagne<br>
              <input type="checkbox" value='Charcoal'>

              Charcoal<br>
              <input type="checkbox" value='Cream'>
              Cream<br>
              <input type="checkbox" value='Dark Green'>
              Dark Green<br>
            </td>
            <td valign="top" class="normal">

              <input type="checkbox" value='Gold'>
              Gold<br>
              <input type="checkbox" value='Green'>
              Green<br>
              <input type="checkbox" value='Grey'>
              Grey<br>
              <input type="checkbox" value='Light Green'>

              Light Green<br>
              <input type="checkbox" value='Mult-color'>
              Mult-color<br>
              <input type="checkbox" value='Offwhite'>
              Offwhite<br>
              <input type="checkbox" value='Orange'>
              Orange<br>

              <input type="checkbox" value='Other'>
              Other<br>
			  <input type="checkbox" value='Pink'>
              Pink
            </td>
            <td valign="top" class="normal">
              <input type="checkbox" value='Purple'>
              Purple<br>

              <input type="checkbox" value='Red'>
              Red<br>
              <input type="checkbox" value='Silver'>
              Silver<br>
              <input type="checkbox" value='Tan'>
              Tan<br>
              <input type="checkbox" value='Turquiose'>

              Turquiose<br>
              <input type="checkbox" value='Unavailable'>
              Blue<br>
              <input type="checkbox" value='White'>
              White<br>
              <input type="checkbox" value='Yellow'>
              Yellow</td>
          </tr>
                    <tr>
            <td valign="top" align="right" class="header">Exterior Color:</td>
            <td valign="top" class="normal">
              <input type="checkbox" value='Beige'>
              Beige<br>
              <input type="checkbox" value='Black'>

              Black<br>
              <input type="checkbox" value='Blue'>
              Blue<br>
              <input type="checkbox" value='Brown'>
              Brown<br>
              <input type="checkbox" value='Burgundy'>
              Burgundy<br>

              <input type="checkbox" value='Champagne'>
              Champagne<br>
              <input type="checkbox" value='Charcoal'>
              Charcoal<br>
              <input type="checkbox" value='Cream'>
              Cream<br>
              <input type="checkbox" value='Dark Green'>

              Dark Green<br>
            </td>
            <td valign="top" class="normal">
              <input type="checkbox" value='Gold'>
              Gold<br>
              <input type="checkbox" value='Green'>
              Green<br>

              <input type="checkbox" value='Grey'>
              Grey<br>
              <input type="checkbox" value='Light Green'>
              Light Green<br>
              <input type="checkbox" value='Mult-color'>
              Mult-color<br>
              <input type="checkbox" value='Offwhite'>

              Offwhite<br>
              <input type="checkbox" value='Orange'>
              Orange<br>
              <input type="checkbox" value='Other'>
              Other<br>
			  <input type="checkbox" value='Pink'>
              Pink
            </td>
            <td valign="top" class="normal">

              
              <input type="checkbox" value='Purple'>
              Purple<br>
              <input type="checkbox" value='Red'>
              Red<br>
              <input type="checkbox" value='Silver'>

              Silver<br>
              <input type="checkbox" value='Tan'>
              Tan<br>
              <input type="checkbox" value='Turquiose'>
              Turquiose<br>
              <input type="checkbox" value='White'>
              White<br>

              <input type="checkbox" value='Yellow'>
              Yellow<br>
              <input type="checkbox" value='None'>
              None</td>
          </tr>
                    <tr>
            <td valign="top" align="right" class="header">Title:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" value='New'>
              New<br>
              <input type="checkbox" value='Used'>
              Used<br>
              <input type="checkbox" value='Reconditioned'>
              Reconditioned</td>
          </tr>
          <tr>
            <td valign="top" align="right" class="header">Title Status:</td>
            <td valign="top" colspan="3" class="normal">
              <input type="checkbox" value='Clear'>
              Clear<br>
              <input type="checkbox" value='Duplicate'>

              Duplicate<br>
              <input type="checkbox" value='Flood'>
              Flood<br>
              <input type="checkbox" value='Salvage'>
              Salvage<br>
              <input type="checkbox" value='Other'>
            Other</td>
          </tr>
          <tr>
            <td valign="top" align="right" class="header">Misc:</td>
            <td valign="top" colspan="3" class="normal"><input type="checkbox" value="Yes" >
              Warranty<br>
              <input type="checkbox" value="Yes" >
              Certified<br>

              <input type="checkbox" value="Yes" >
              Security System<br>
                            <input type="checkbox" value="Yes" >
              GPS/Navigation System<br>
                                          <input type="checkbox" value="Yes" >
              Hitch<br>
                                                        <input type="checkbox" value="Yes" >

              Air Conditioning </td>
          </tr>
    </table>
		  
<table align="center" border="0" cellspacing="0" cellpadding="0" background="images/usmap.gif">
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>

		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>

		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>

		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>

		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value='WA'></td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="ND"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MT"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MN"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="ME"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="OR"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="SD"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="WI"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="VT"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="ID"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="WY"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MI"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NY"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NH"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>

		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NE"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="IA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="CT"></td>
		<td><input type="checkbox" name="state[]" value="RI"></td>
		<td><input type="checkbox" name="state[]" value="MA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NV"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="IL"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="IN"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="OH"></td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="PA"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NJ"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="UT"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="CO"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td><input type="checkbox" name="state[]" value="KS"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MO"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="WV"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="MD"></td>
		<td><input type="checkbox" name="state[]" value="DE"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="CA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td><input type="checkbox" name="state[]" value="KY"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="VA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td><input type="checkbox" name="state[]" value="TN"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AZ"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NM"></td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="OK"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AR"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="NC"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td><input type="checkbox" name="state[]" value="MS"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="GA"></td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="SC"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="TX"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AL"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="AK"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="LA"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>

		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="FL"></td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

	</tr>
	<tr>
		<td><img border="0" src="images/blank.gif" width="20" height="20"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="checkbox" name="state[]" value="HI"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

		<td></td>
	</tr>
				
</table>		  
		  
		  
		  
		  <table align="center">
		  <tr>
            <td height="42" colspan="4" align="center" class="normal">
            <input type="submit" value="Search" /></td>
          </tr>
        </table><i>fig 4.5</i>
  <p><span class="style2"><a name="Chp4_WatchinganAuction">Watching an Auction </a></span></p>
  <p><span class="MsoNormal">To watch an auction, simply search or browse to
      the auction, then select the button to the upper right of the auction page
      that says &quot;Add to my watch list.&quot; This selection opens a page
      for you to adjust the time the email reminder alert will be sent to you.
      See figure 4.6 below for an example.</span></p>
  <p><img src="images/EmailReminder.gif" width="583" height="609"><i>fig 4.6</i></p>
  <p class="MsoNormal">This page also shows the details about the auction end
    time. The default time for the email reminder alert is 5 hours before the
    end of the auction. You can adjust this time to whatever you would like on
    the hour. This will send you an email reminding you about the auction and
    the end time. It will display the current high bid at the time of the email
    and a link for you to visit the auction.</p>
  <p class="MsoNormal">To view all of your watched auctions, click the My Watch
    List link in the control panel. See figure 4.7 below.</p>
  <p class="MsoNormal"><img src="images/MyWatchList.gif" width="763" height="195"><i>fig
      4.7</i></p>
  <p class="MsoNormal">This page displays your current watch list. From here
    you can edit the time of the email reminder alert, delete the auction from
    your watched list, and details about the auction including the category,
    title, status, end of auction time and when your reminder is set for.</p>
  <p class="MsoNormal">** NOTE ** The time is set in military time and also for
    Central Daylight Time (CDT).</p>
  <p class="MsoNormal"><a name="Chp4_Placingabid"><span style="font-size: 16pt;">Placing
  a Bid</span></a></p>
  <p class="MsoNormal">Bidding can only be done by  users with privileges to
    buy. This is discussed in the Manage Users section.</p>
  <p class="MsoNormal">Assuming you have authorization to bid on an auction,
    you will need to find an  open auction to
    bid on. 

Conduct a search or browse to an auction that is not part of your inventory.</p>
  <p class="MsoNormal">** NOTE ** The system will not allow you to bid on items
    in your online inventory. You can view them, but the bidding options are
    removed. </p>
  <p class="MsoNormal">In the auction page, you will see where the bidding starts,
    if there are no bids, or the current bid if there have been bids made prior.
    You will also see all the other details about the auction and the item along
    with the seller's current rating. If a reserve was set on the auction by
    the seller, you will see if the reserve has been met or not. Also, you will
    see if the seller has made the option for a Buy Now. There will be a button
    for you to click to place your bid with the amount of the bid shown in the
    button. The same is true for the Buy Now option. See figure 4.8 below for
    an example. </p>
  <p class="MsoNormal" style="text-align: right;" align="right"><img src="images/Auction.gif"><i>fig
      4.8</i></p>
  <p class="MsoNormal">Once the auction meets or exceeds the seller's reserve,
    the Buy Now option will not be available. </p>
  <p class="MsoNormal">** NOTE ** If the seller has lowered the reserve, you
    will see a graphic in the auction showing the reserve has been lowered.</p>
  <p class="MsoNormal">In this example, we can see that the seller has a rating
    of 4.37. This is covered more in detail in the Rate Sellers section. You
    can also see whether the reserve has been met, the current bid, the next
    bid, the auction's start time, the auction's end time, and where it is located.
    You can also see how many bids have been placed as well. You cannot see what
    the current high bidder's maximum bid is. You will need to place a bid with
    your maximum bid higher than the current high bidder's maximum bid to be
    the winning bidder.</p>
  <p class="MsoNormal">You will need to verify the location and what is chosen
    in the Who pays transport field, plus all description and condition reports
    to verify your wholesale bidding prices. </p>
<p class="MsoNormal"><a name="Chp4_Buynow"><span style="font-size: 16pt;">Buy
      Now</span></a></p>
<p class="MsoNormal">Another way to purchase a item is to select the Buy
    Now button on the auction.

This option is only available if the seller offers the Buy Now feature.
    There are no

additional fees when using this feature to either the seller or the buyer. The
  same buy fees will still exist as with any other auction. The auction will
  immediately end and you will be the winner of the auction. This feature is
  very helpful when needing the item right away to close a deal, or if you do
  not want to wait for the end of the auction.&nbsp; </p>
<p class="MsoNormal"><a name="Chp4_Ratesellers"><span style="font-size: 16pt;">Rate
Sellers</span></a></p>
<p class="MsoNormal">The rating system is a very important part of the system.
  This tool allows the buyer to rate the seller on every auction. Do not submit
  the rating evaluation until your transaction will the seller has been completed.
  See figure 4.9 for an example of the rating screen.</p>
<p class="MsoNormal">&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr valign="top">
          <td>
            <h3 align="center"><b>Rate Seller</b></h3>
            <h6 align="center" class="style8">Please use the following<br>
              Go Dealer To Dealer&copy; Member Rating System:</h6>
            <table align="center" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td align="center" class="big" colspan="6">
                  <table border="0" cellpadding="3" cellspacing="0">
                    <tr>
                      <td class="normal style10">Excellent</td>
                      <td class="normal style10">5 points</td>
                    </tr>
                    <tr>
                      <td class="normal style10">Good</td>
                      <td class="normal style10">4 points</td>
                    </tr>
                    <tr>
                      <td class="normal style10">Average</td>
                      <td class="normal style10">3 points</td>
                    </tr>
                    <tr>
                      <td class="normal style10">Fair</td>
                      <td class="normal style10">2 points</td>
                    </tr>
                    <tr>
                      <td class="normal style10">Poor</td>
                      <td class="normal style10">1 point</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td class="big style11"><b>Auction #138 : <b>1967 Chevelle</b></b></td>
                <td align="center"><span class="style11">1</span></td>
                <td align="center"><span class="style11">2</span></td>
                <td align="center"><span class="style11">3</span></td>
                <td align="center"><span class="style11">4</span></td>
                <td align="center"><span class="style11">5</span></td>
              </tr>
              <tr>
                <td class="normal style11">Timeliness of Initial Contact &amp; Business
                  Communication</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td class="normal">Accuracy of Item Description</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td class="normal">Accuracy of Item Condition</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td class="normal">Availability of Title/Certificate</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td class="normal">Prompt Payment Coordination</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td class="normal">Prompt Transport Coordination</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td class="normal">Overall Professionalism</td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio"></td>
                <td align="center"><input type="radio" checked></td>
              </tr>
              <tr>
                <td colspan="6">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" class="normal style11">Note: your comments will
                  be delivered to our Quality Control Dept. at GoDealerToDealer
                  Headquarters.</td>
              </tr>
              <tr>
                <td colspan="6">&nbsp;</td>
              </tr>
              <tr>
                <td class="normal" colspan="6"><div align="left" class="style11">Buyer's
                    Comments<br />
                        <textarea cols="70" 
	rows="4" wrap="VIRTUAL">This is just an example.  Your comments and/or ratings will not be submitted.</textarea>
                </div></td>
              </tr>
            </table>
            <div align="center">
              <p>
                <input type="submit" value=" Rate Seller " />
              </p>
          </div></td>
        </tr>
    </table></td>
  </tr

  >
</table>
<p class="MsoNormal" style=" text-align: right;" align="right"><i>fig 4.9</i></p>
<p class="MsoNormal">From here, you can see that there are 7 items to rate the
  seller on. These items are then calculated together and combined with all other
  transactions to provide a numerical value for the seller in all auctions.</p>
<p class="MsoNormal">The default for the ratings are set to 5 (the highest rating).
  If there have been problems or issues, then you should rate the seller appropriately.
  If there were serious issues of problems, please enter your comments (not mandatory)
  in the comments field. This will be delivered to the seller's Account Executive
  as well as our Quality Control for further review. </p>
<p class="MsoNormal"><a name="Chp4_Managingbids"><span style="font-size: 16pt;">Managing Bids</span></a></p>
<p class="MsoNormal"><span class="MsoNormal style4"><span style="">Bids for Open
Auctions </span></span></p>
<p class="MsoNormal">Managing your bids has been made very easy. To view and
  manage your bids for open auctions, click the My Bids link in the Control Panel.
  See figure 4.10 to see the Bids for Open Auctions page. </p>
  <p class="MsoNormal" style=" text-align: right;" align="right"><img 

src="images/BidsOpenAuctions.gif"  border="0" height="467" width="791"><i>fig
      4.10</i></p>
  <p class="MsoNormal">This page displays all auctions you currently have bids
    on that are still open. The bidder column shows who in your company placed
    the bid for the item. The status shows if you are winning or losing the auction.
    If your maximum bid did not meet the reserve, this is also shown in the status
    which should also be considered as losing. You will see your current and
    maximum bids for each item. If you did not enter a maximum bid for an auction,
    then $0 will display for the maximum bid column.</p>
  <p class="MsoNormal"><span class="MsoNormal style4"><span style="">Bids for
  Closed Auctions</span></span></p>
  <p class="MsoNormal">Managing bids for closed auctions is done by clicking
    the My Bids link in the Control Panel, and then selecting the Bids for Closed
    Auctions link in the menu. This will open the Bids for Closed Auctions report
    as shown in figure 4.11 below. </p>
  <p class="MsoNormal" style=" text-align: right;" align="right"><img 

src="images/BidsClosedAuctions.gif"  border="0" height="408" width="680"><i>fig
      4.11</i></p>
  <p class="MsoNormal">From here you can see the final end result of the auctions
    that you participated in. You will see the user in your company who placed
    the bid and the final status of the bid, either won or lost. A pulled entry
    in the status column indicates the seller pulled the auction before meeting
    reserve. This is most likely because the seller was able to retail the item
    before the end of the auction. Once the item has met reserve the seller is
    no longer able to pull the item from an auction.</p>
  <p class="MsoNormal">You can also see the bid amounts and the maximum bids
    placed on these auctions.</p>
  <p class="MsoNormal"><span class="MsoNormal style4"><span style="">Bids for
  Auctions Won </span></span></p>
  <p class="MsoNormal">This report will show you only the auctions that your
    company has won.&nbsp;This section makes it easier to view only the auctions
    won on a single page with the amount and the user who placed the winning
  bid. See figure 4.12 below.</p>
  <p class="MsoNormal" style=" text-align: right;" align="right"><img 

src="images/BidsAuctionsWon.gif"  border="0" height="159" width="592"><i>fig
      4.12</i></p>
  <p class="MsoNormal">&nbsp;</p>
  <p class="MsoNormal">These items will be available for 60 days. You can view
    the auction by clicking on the Auction Name and a print out can be made for
    your records.</p>
  <p class="MsoNormal"><span class="MsoNormal style4"><span style="">All Bids</span></span></p>
  <p class="MsoNormal">This section displays a historical view of every 
    bid made on any auctions within this system. This view is useful for viewing
    the history of each auction, your bids, and the current status of that auction
    with regards to your bids. As seen below in figure 4.13, the auctions are
    grouped together with each bid with the top most bid being the most current.
    The last bid will have a status and all others below will have an up arrow. </p>
  <p class="MsoNormal" style=" text-align: right;" align="right"><img 

src="images/BidsAllAuctions.gif"  border="0" height="553" width="787"><i>fig
      4.13</i></p>
  	<table align="center" width="80%">
	<tr><td width="53%" align="left"><a href="chp3.php">Previous</a></td>
	<td width="47%" align="right"><a href="chp5.php">Next</a></td>
	</tr></table>
  <p class="MsoNormal" style="text-align: center;" align="center"><span style="font-size: 

14pt;"><a href="index.php">Table of Contents</a></span></p>
  <p class="MsoNormal" style="text-align: center;" align="center"><span style="font-size: 

14pt;"><a href="http://[SERVER_NAME]/auction/index.php">Go Dealer to Dealer Home 

Page</a></span></p>

</body>
