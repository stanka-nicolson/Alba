<?php
include('../header.html');
?>
<div class="index-content" >
<div class="content" >

		<ul class="tab-list">
			<li class="active"><a class="tab-control" href="#tab-1"><h3>Fares</h3></a></li>
			<li><a class="tab-control" href="#tab-2" ><h3>Spring&Autumn timetable</h3></a></li>
			<li><a class="tab-control" href="#tab-3"><h3>Summer timetable</h3></a></li>
		</ul>
	
		
		<div class="tab-panel active" id="tab-1">
			<h2>Fares</h2>
			<p>All fares are for return trip</p>
			<div id="table" >
			<table width="900" border="1">
				<tr>
					<th width="35">Destination</th>
					<th width="35">Adult</br>(over 17 years old)</th>
					<th width="35">Child</br>(11-16 years old)</th>
					<th width="35">Child</br>(3-10 years old)</th>
					<th width="35">Infant</br>(under 2 years old)</th>
				</tr>
			
<?php
$file_handle = fopen("../text/price.txt", "r",FILE_SKIP_EMPTY_LINES);

while (!feof($file_handle) ) {
    $line_of_text = fgets($file_handle);
	//echo'<p>'.$line_of_text.'</p>';
    $parts = explode('/', $line_of_text);
    echo "<tr>
			<td height='50'>$parts[0]</td>
			<td>$parts[1]</td>
			<td>$parts[2]</td>
			<td>$parts[3]</td>
			<td>$parts[4]</td>
		</tr>";
}
fclose($file_handle);
?>			
			</table>
			</div><!--table 1 id table -->
		</div><!--table 1 .tab-panel -->

        <div class="tab-panel" id="tab-2">
            <h2>Spring&Autumn timetable</h2>
            <p>Spring period valid from 20 May 2019 - 31 May 2019.</p>
			<p>Autumn period valid from 1 September 2019 - 21 October 2019 </p>
			<div id="table" >
			<table width="900" border="1">
				<tr>
					<th width="35">DAY</th>
					<th width="35">Morar</br>Depart</th>
					<th width="35">Eigg</br>Arrive</th>
					<th width="35">Eigg</br>Depart</th>
					<th width="35">Muck</br>Arrive</th>
					<th width="35">Muck</br>Depart</th>
					<th width="35">Rum</br>Arrive</th>
					<th width="35">Rum</br>Depart</th>
					<th width="35">Eigg</br>Arrive</th>
					<th width="35">Eigg</br>Depart</th>
					<th width="35">Morar</br>Arrive</th>
		
				</tr>
<?php
$file_handle = fopen("../text/schedule1.txt", "r",FILE_SKIP_EMPTY_LINES);

while (!feof($file_handle) ) {
    $line_of_text = fgets($file_handle);
	//echo'<p>'.$line_of_text.'</p>';
    $parts = explode('/', $line_of_text);
    echo "<tr>
			<td height='50'>$parts[0]</td>
			<td>$parts[1]</td>
			<td>$parts[2]</td>
			<td>$parts[3]</td>
			<td>$parts[4]</td>
			<td>$parts[5]</td>
			<td>$parts[6]</td>
			<td>$parts[7]</td>
			<td>$parts[8]</td>
			<td>$parts[9]</td>
			<td>$parts[10]</td>
		</tr>";
}
fclose($file_handle);
?>
			</table>
			</div><!-- table 2.table2 -->
        </div><!-- table 2.tab2 -->

        <div class="tab-panel" id="tab-3">
            <h2>Summer timetable</h2>
            <p>Summer period valid from 1 June 2019 - 31 August 2019</p>

			<div id="table" >
			<table style="width:100%">
				<tr>
					<th width="35">DAY</th>
					<th width="35">Morar</br>Depart</th>
					<th width="35">Eigg</br>Arrive</th>
					<th width="35">Eigg</br>Depart</th>
					<th width="35">Muck</br>Arrive</th>
					<th width="35">Muck</br>Depart</th>
					<th width="35">Rum</br>Arrive</th>
					<th width="35">Rum</br>Depart</th>
					<th width="35">Eigg</br>Arrive</th>
					<th width="35">Eigg</br>Depart</th>
					<th width="35">Morar</br>Arrive</th>
				</tr>
<?php
$file_handle = fopen("../text/schedule.txt", "r",FILE_SKIP_EMPTY_LINES);

while (!feof($file_handle) ) {
    $line_of_text = fgets($file_handle);
	//echo'<p>'.$line_of_text.'</p>';
    $parts = explode('/', $line_of_text);
    echo "<tr>
			<td height='50'>$parts[0]</td>
			<td>$parts[1]</td>
			<td>$parts[2]</td>
			<td>$parts[3]</td>
			<td>$parts[4]</td>
			<td>$parts[5]</td>
			<td>$parts[6]</td>
			<td>$parts[7]</td>
			<td>$parts[8]</td>
			<td>$parts[9]</td>
			<td>$parts[10]</td>
		</tr>";
}
fclose($file_handle);
?>
			</table>
			</div><!-- table 3.table3 -->
		</div><!--table 3 .tab3 -->
		
		
<p>Morar also offers a Thai Restaurant and a Roman Catholic church, plus a large garage at the foot of the hill near the northern junction onto the bypass. Its population is a little over 200.</p>

<p>Morar as the village is less well known than Morar as the large and lonely peninsula on which it stands: and it is also less well known than Loch Morar, whose east-west gash nearly splits the peninsula in two.</p>

<p>Loch Morar is 12 miles long and over a mile wide in places. It fails to meet the sea at its western end by a few hundred yards: and the village of Morar occupies part of the strip of land that was left. The River Morar, one of the shortest in the country, carries the outflow of Loch Morar across this strip, though in doing so it falls 40 feet in some spectacular cascades.</p>

<p>Much of the loch, and its east end in particular, is wild, moutainous, and exceptionally lonely. It is much easier to accept the possibility of an undiscovered monster here than in the vastly more travelled Loch Ness. The west end of the Loch at the village of Morar is more popular, with quite a lot of small boating activity, especially in summer. definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
</div><!--content -->
</div><!-- index-content -->
<script src="/alba/js/jquery-1.11.0.min.js"></script>
<script src="/alba/js/tabs.js"></script>

<?php
 $path = $_SERVER['DOCUMENT_ROOT'];
 $path .= "/alba/view/footer.html";
include_once($path);
?>