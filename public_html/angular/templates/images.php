<?php require_once("header.php");?>

<!--div class="container-fluid">
	<div class="txt-2">
		<h3 class="txt-2">redrovr</h3>
		<h3 class="txt-3">Images</h3>
	</div
</div-->

<div class="container-fluid">
<div class="row heading-row">
	<div >
	<h1 class="col-sm-6 txt-2">redrovr</h1>
	</div>
	<div>
	<h2 class="col-sm-6 txt-3">Images</h2>
	</div>
	<hr style="clear:both;" id="heading-hr"/>
</div>


<div class="row carousel-row">
<div id="imageCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<!--img src="../public_html/image/above-shot.jpg" alt="Above-Mars"-->
			<div style="background:url(../public_html/image/above-shot.jpg) center center;
			background-size:cover;" class="slider-size" onclick="slideBox('slide-1');" id="slide-1">
          background-size:cover;" class="slider-size">
			<div class="carousel-caption">
				<h3>Orbit Shot</h3>
				<p>Rover tracks at "the Kimberley" -April 2014</p>
			</div>
			</div>
		</div>
		

		<div class="item">
			<div style="background:url(../public_html/image/mars-landscape.jpg) center center;
          background-size:cover;" class="slider-size" onclick="slideBox('slide-2');" id="slide-2">
			<div class="carousel-caption">
				<h3>Sand and Rock</h3>
				<p>Here you can see a wideshot picture of the landscape of Mars' surface, covered in sand dunes and bits of rock.</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/sunset.gif) center center;
          background-size:cover;" class="slider-size" onclick="slideBox('slide-3');" id="slide-3">
			<div class="carousel-caption">
				<h3>A Sunset On Mars</h3>
				<p>Due to atmospheric differences between Earth and Mars, sunsets look a bit more bland and unexciting on the Red Planet.</p>
				</div>
			</div>
		</div>


		<div class="item">
			<div style="background:url(../public_html/image/selfie-optimized.jpg) center center;
          background-size:cover;" class="slider-size" onclick="slideBox('slide-4');" id="slide-4">
			<div class="carousel-caption">
				<h3>Rover Selfie</h3>
				<p>The Curiosity Rover takes a full-shot selfie while traveling on the surface of Mars.</p>
				</div>
			</div>
		</div>

<!--begin picture adding for demo-->
		<div class="item">
			<div style="background:url(../public_html/image/ciriosity-orbit-tracks.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>Tracks</h3>
					<p>A colored image of the surface, showing Curiosity's left over tracks.</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/contact.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>Landing on Mars!</h3>
					<p>Mars Science Laboratory Team celebrates as Curiosity lands safely on the surface of Mars and images begin coming in. -Aug. 5, 2012</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/selfie-2.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>Curiosity Self-Portrait at 'Windjana' Drilling Site</h3>
					<p>Taken on Sol 613, beginning drilling.</p>
				</div>
			</div>
		</div>


		<div class="item">
			<div style="background:url(../public_html/image/stars-and-stripes.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>Curiosity's Stars and Stripes</h3>
					<p>A view of the American flag medallion mounted on the Curiosity</p>
				</div>
			</div>
		</div>


		<div class="item">
			<div style="background:url(../public_html/image/wheels-and-destination.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity Snaps a Moving Photo of It's Wheels</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/whale-rock.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>"Whale Rock" - Proof of Ancient Lake</h3>
					<p>Whale Rock is covered in cross-bedding, which results from water passing over it.</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/stream-flow-evidence.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>This Image Shows Evidence of Stream Flow</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/tracks.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curious Tracks</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/destination-crater.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity's Landing Site</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/martian-crystals.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Crystal-Laden Martian Rock - Examined by Curiosity's Laser Instrument</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/martian-moonrise.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity Snaps a Photo of Phobos Rising Into the Night Sky</p>
				</div>
			</div>
		</div>


		<div class="item">
			<div style="background:url(../public_html/image/iron-meteroite.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>An Iron Meteorite Found On the Surface</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/drill-site.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>One of Curiosity's Many Drilling Sites</h3>
					<p>One of Curiosity's many tools is a large drill. The machine uses the drill to take samples and view rock structures beneath the surface of the planet.</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/mars-surface-long-drive.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity Takes a Shot While On It's Longest Drive to Date</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/panorama.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity Takes a Panorama</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/parachute.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Parachute Used for Curiosity Landing</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/pathway.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity's Path</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/labels.jpg) center center;
          background-size:cover;" class="slider-size">
			</div>
		</div>


		<div class="item">
			<div style="background:url(../public_html/image/rock-garden.jpg) center center;
          background-size:cover;" class="slider-size">
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/mars-flower.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>A Transparent Rock Feature Dubbed a "Flower"</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/earth-moon.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Curiosity Takes a Sky Shot Displaying Earth and Our Moon from the Surface of Mars</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/martian-spoon.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<h3>A Spoon on Mars?</h3>
					<p>Nope. Just a rock.</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/mars-explorer-gif.gif) center center;
          background-size:cover;" class="slider-size">
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/phobos-deimos-comparison.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>A Comparison of Phobos, Mars' Moon, and Earth's Moon</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/mars-moon-phobos-solar-eclipse.jpg) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
					<p>Phobos Causes a Solar Eclipse of Mars</p>
				</div>
			</div>
		</div>

		<div class="item">
			<div style="background:url(../public_html/image/rover-movement.gif) center center;
          background-size:cover;" class="slider-size">
				<div class="carousel-caption">
			</div>
		</div>

			<div class="item">
				<div style="background:url(../public_html/image/moving-water.gif) center center;
          background-size:cover;" class="slider-size">
					<div class="carousel-caption">
						<p>Mars Proves there is Flowing Water on Today's Mars!</p>
					</div>
				</div>
			</div>



		<!--end added pictures for demo-->
	</div>

	<!-- Left and right controls -->
	<a class="left carousel-control" href="javascript:void(0)" role="button" data-slide="prev" data-target="#imageCarousel">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="javascript:void(0)"  role="button" data-slide="next" data-target="#imageCarousel">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>
</div>
	<!--begin modal -->
	<div class="modal fade modal-fullscreen force-fullscreen" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

				</div>
					<div class="modal-body" id="imgModalImage">

					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>