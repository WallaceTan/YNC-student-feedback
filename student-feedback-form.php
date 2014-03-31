<?php
/**
 * Template used for displaying page content in student-feedback-page.php
 *
 * @package WordPress
 * @subpackage yalenus-microsite
 * @since yalenus-microsite 0.1
  */
?>
<script type="text/javascript">
var data = <?php echo json_encode($data); ?>;

(function($) {

	$( document ).ready(function() {
		// Populate courses select dropdown box
		$.each(data, function ( index, value ) {
			console.log( index + "  course: " + value.course + "  instructors: " + value.instructors + " Array.isArray(" + Array.isArray(value.instructors) + ")" + " Array length(" + value.instructors.length + ")");
			$('#courses').append('<option value="' + value.id + '">' + value.course + '</option>');
		});
		// Attached onChange event to courses select dropdown box
		$('#courses').change( function () {
			set_instructors( $(this).val(), data );
			toggle_feeback_form( $(this).val() );
		});
//		$('#courses').blur( function () {
//			set_instructors($(this).val(), data);
//			toggle_feeback_form( $(this).val() );
//		});

		// Set focus to courses select dropdown box
		$( "#courses" ).focus();
		// $( "#courses" ).blur();

		$( "#Q_C6_1" ).click(function() {
			$( "#Q_C6A" ).slideDown( "slow" );
		});
		$( "#Q_C6_2" ).click(function() {
			$( "#Q_C6A" ).slideUp( "slow" );
		});
		
	});

	function toggle_feeback_form( id ) {
		if ( parseInt( id ) > 0 ) {
			if ($( "#feeback_form" ).is( ":visible" )) {
				$( "#feeback_form" ).hide();
			}
			$( "#feeback_form" ).slideDown( "slow" );
		} else {
			$( "#feeback_form" ).hide();
		}
	};

	function set_instructors( id, data ) {
		// find instructors 
		$.each(data, function ( index, value ) {
			if ( value.id == id ) {
				instructors = ( value.instructors.length > 1 ) ? "Seminar Professors: " : "Seminar Professor: ";
				instructors += value.instructors;
				$( "#instructors" ).text( instructors );
				return false;
			}
		});
	}

})(jQuery);
</script>

<form>
<p>Course Name: <select id="courses"><option value="0">--- Please Select ---</option></select></p>

<div id="feeback_form">
<p id="instructors"></p>

<p>Please answer the following questions honestly and completely.  The information you provide will be used to improve the structure and teaching of the course in the future.  It will also be used to assess and improve the teaching of the faculty and at the college in general.  The faculty will have access to your anonymous feedback only after the marking period is complete.  We appreciate your perspective on the course.</p>

<p>In LH2 and PPT2, the lecture refers to the parts of the course at which all students were present.  The seminar refers to the parts of your course involving only your (smaller) seminar group. For all other courses there is no distinction between lecture and seminar.</p>

<div id="SECTION_A" class="section">
<div class="section-header">Part A:  The following three questions address the course overall, including lecture and seminar.</div>

<label for="Q_A1" class="question">1. What helped you learn in the course overall?  (for example, lecture, seminar discussions, seminar professor, readings, assignments, and connections to other courses).  Briefly explain why you found them helpful.</label>
<textarea id="Q_A1" name="Q_A1" cols="120" rows="3"></textarea>

<label for="Q_A2" class="question">2. How could this course change in the future to improve student learning?</label>
<textarea id="Q_A2" name="Q_A2" cols="120" rows="3"></textarea>
 
<label for="Q_A3" class="question">3. Briefly describe how your seminar professor(s) taught the seminar, including any distinctive features or activities.</label>
<textarea id="Q_A3" name="Q_A3" cols="120" rows="3"></textarea>
</div>

<div id="SECTION_B" class="section">
<div class="section-header">Part B:  Describe your effort in the class;</div>

<label for="Q_B1" class="question">1. Describe your effort in this course compared to others you have taken at Yale-NUS.</label>
<input id="Q_B1_1" name="Q_B1" type="radio" value="1" hidden><label for="Q_B1_1" class="switch switch--off">Much less effort</label>
<input id="Q_B1_2" name="Q_B1" type="radio" value="2" hidden><label for="Q_B1_2" class="switch switch--off">Less effort</label>
<input id="Q_B1_3" name="Q_B1" type="radio" value="3" hidden><label for="Q_B1_3" class="switch switch--off">Average effort</label>
<input id="Q_B1_4" name="Q_B1" type="radio" value="4" hidden><label for="Q_B1_4" class="switch switch--off">More effort</label>
<input id="Q_B1_5" name="Q_B1" type="radio" value="5" hidden><label for="Q_B1_5" class="switch switch--off">Much more effort</label>

<label for="Q_B2" class="question">2. How many hours did you spend on this course in a typical week, <b>not</b> including scheduled seminar or lecture time?</label>
Hours per week: <input id="Q_B2" name="Q_B2" type="text" value="" />
</div>

<div id="SECTION_C_I1" class="section">
<div class="section-header">Part C: Describe aspects of the course related specifically to your seminar professor : __________ (need to specify name if two instructors in course).</div>

<p>Express your level of agreement with the following statements:</p>

<label for="Q_C1" class="question">1. The seminar professor helped me understand course concepts.</label>
<input id="Q_C1_1" name="Q_C1" type="radio" value="1" hidden><label for="Q_C1_1" class="switch switch--off">Strongly disagree</label>
<input id="Q_C1_2" name="Q_C1" type="radio" value="2" hidden><label for="Q_C1_2" class="switch switch--off">Disagree</label>
<input id="Q_C1_3" name="Q_C1" type="radio" value="3" hidden><label for="Q_C1_3" class="switch switch--off">Neutral</label>
<input id="Q_C1_4" name="Q_C1" type="radio" value="4" hidden><label for="Q_C1_4" class="switch switch--off">Agree</label>
<input id="Q_C1_5" name="Q_C1" type="radio" value="5" hidden><label for="Q_C1_5" class="switch switch--off">Strongly agree</label>

<label for="Q_C2" class="question">2. The seminar professor challenged me to actively engage the material.</label>
<input id="Q_C2_1" name="Q_C2" type="radio" value="1" hidden><label for="Q_C2_1" class="switch switch--off">Strongly disagree</label>
<input id="Q_C2_2" name="Q_C2" type="radio" value="2" hidden><label for="Q_C2_2" class="switch switch--off">Disagree</label>
<input id="Q_C2_3" name="Q_C2" type="radio" value="3" hidden><label for="Q_C2_3" class="switch switch--off">Neutral</label>
<input id="Q_C2_4" name="Q_C2" type="radio" value="4" hidden><label for="Q_C2_4" class="switch switch--off">Agree</label>
<input id="Q_C2_5" name="Q_C2" type="radio" value="5" hidden><label for="Q_C2_5" class="switch switch--off">Strongly agree</label>

<label for="Q_C3" class="question">3. I am motivated to explore beyond the material I encountered in seminar.</label>
<input id="Q_C3_1" name="Q_C3" type="radio" value="1" hidden><label for="Q_C3_1" class="switch switch--off">Strongly disagree</label>
<input id="Q_C3_2" name="Q_C3" type="radio" value="2" hidden><label for="Q_C3_2" class="switch switch--off">Disagree</label>
<input id="Q_C3_3" name="Q_C3" type="radio" value="3" hidden><label for="Q_C3_3" class="switch switch--off">Neutral</label>
<input id="Q_C3_4" name="Q_C3" type="radio" value="4" hidden><label for="Q_C3_4" class="switch switch--off">Agree</label>
<input id="Q_C3_5" name="Q_C3" type="radio" value="5" hidden><label for="Q_C3_5" class="switch switch--off">Strongly agree</label>

<label for="Q_C4" class="question">4. I found it easy to obtain prompt feedback from the seminar professor.</label>
<input id="Q_C4_1" name="Q_C4" type="radio" value="1" hidden><label for="Q_C4_1" class="switch switch--off">Strongly disagree</label>
<input id="Q_C4_2" name="Q_C4" type="radio" value="2" hidden><label for="Q_C4_2" class="switch switch--off">Disagree</label>
<input id="Q_C4_3" name="Q_C4" type="radio" value="3" hidden><label for="Q_C4_3" class="switch switch--off">Neutral</label>
<input id="Q_C4_4" name="Q_C4" type="radio" value="4" hidden><label for="Q_C4_4" class="switch switch--off">Agree</label>
<input id="Q_C4_5" name="Q_C4" type="radio" value="5" hidden><label for="Q_C4_5" class="switch switch--off">Strongly agree</label>

<label for="Q_C5" class="question">5. The seminar professor's responses to my work were valuable.</label>
<input id="Q_C5_1" name="Q_C5" type="radio" value="1" hidden><label for="Q_C5_1" class="switch switch--off">Strongly disagree</label>
<input id="Q_C5_2" name="Q_C5" type="radio" value="2" hidden><label for="Q_C5_2" class="switch switch--off">Disagree</label>
<input id="Q_C5_3" name="Q_C5" type="radio" value="3" hidden><label for="Q_C5_3" class="switch switch--off">Neutral</label>
<input id="Q_C5_4" name="Q_C5" type="radio" value="4" hidden><label for="Q_C5_4" class="switch switch--off">Agree</label>
<input id="Q_C5_5" name="Q_C5" type="radio" value="5" hidden><label for="Q_C5_5" class="switch switch--off">Strongly agree</label>

<label for="Q_C6" class="question">6A. Did you interact with the seminar professor outside of class?</label>
<input id="Q_C6_1" name="Q_C6" type="radio" value="1" hidden><label for="Q_C6_1" class="switch switch--off">YES</label>
<input id="Q_C6_2" name="Q_C6" type="radio" value="2" hidden><label for="Q_C6_2" class="switch switch--off">NO</label>

<div id="Q_C6A" class="question-set">
<label for="Q_C6A" class="question">6B. Did you receive constructive assistance?</label>
<input id="Q_C6A_1" name="Q_C6A" type="radio" value="1" hidden /><label for="Q_C6A_1" class="switch switch--off">Strongly disagree</label>
<input id="Q_C6A_2" name="Q_C6A" type="radio" value="2" hidden /><label for="Q_C6A_2" class="switch switch--off">Disagree</label>
<input id="Q_C6A_3" name="Q_C6A" type="radio" value="3" hidden /><label for="Q_C6A_3" class="switch switch--off">Neutral</label>
<input id="Q_C6A_4" name="Q_C6A" type="radio" value="4" hidden /><label for="Q_C6A_4" class="switch switch--off">Agree</label>
<input id="Q_C6A_5" name="Q_C6A" type="radio" value="5" hidden /><label for="Q_C6A_5" class="switch switch--off">Strongly agree</label>
</div>
</div>

<div id="SECTION_D" class="section">
<div class="section-header">Part D</div>
<label for="Q_D1">Please use this space to elaborate on your previous responses or to address other issues such as classroom atmosphere; most or least helpful course materials, readings, or topics; or any other specific suggestions or concerns about the course.</label>
<textarea id="Q_D1" name="Q_D1" cols="120" rows="6"></textarea>
</div>

<input type="submit" name="submit" value="Submit" class="btn bg_blue" />

</div> <!--  -->
</form>
<!--
<?php //selected( $selected, $current, $echo ); ?>
$user_login : <?php echo $user_login; ?>
<pre><?php echo json_encode($data); ?></pre>

HUMANITIES (5 MC)
Religions of Abraham (Kreps)
Introduction to Creative Nonfiction (Hemley)
Introduction to Mathematical Logic (C. Liu)

SOCIAL SCIENCES (5 MC except for two half-courses that will run sequentially)
Understanding Behavior and Cognition (Asplund/Bishop)
Intermediate Microeconomics (Saran)*
Intro Math for Econ half-course 2 MC (Saran)*

[
{"id":"1","MC":"5","type":"Module","group":"","name":"Modern Social Thought","abbr":"MST","instructor":"","rule":"required"},
{"id":"2","MC":"12","type":"Module","group":"","name":"Double Degree Program","abbr":"DDP","instructor":""},
{"id":"3","MC":"5","type":"Module","group":"","name":"Foundations of Science 1","abbr":"FS1","instructor":"","rule":"if (DDP==1) required"},
{"id":"4","MC":"10","type":"Module","group":"","name":"Integrated Science 2","abbr":"IS2","instructor":"","rule":"if (IS1==1) optional"},
{"id":"5","MC":"5","type":"Elective","group":"","course":"Micro Economics","abbr":"","instructor":""},
{"id":"6","MC":"2","type":"Elective","group":"","course":"Stats for Econ (half course)","abbr":"","instructor":""},

{"id":"7","MC":"5","type":"Elective","group":"HUMANITIES","course":"Religions of Abraham","abbr":"","instructor":"Kreps","url":"http://courses.yale-nus.edu.sg/religions-of-abraham"},
{"id":"8","MC":"5","type":"Elective","group":"HUMANITIES","course":"Introduction to Creative Nonfiction","abbr":"","instructor":"Hemley","url":"http://courses.yale-nus.edu.sg/"},
{"id":"9","MC":"5","type":"Elective","group":"HUMANITIES","course":"","abbr":"Introduction to Mathematical Logic","instructor":"C. Liu","url":"http://courses.yale-nus.edu.sg/"},

{"id":"10","MC":"5","type":"Elective","group":"SOCIAL SCIENCES","course":"Understanding Behavior and Cognition","abbr":"","instructor":"Asplund/Bishop","url":"http://courses.yale-nus.edu.sg/"},
{"id":"11","MC":"5","type":"Elective","group":"SOCIAL SCIENCES","course":"Intermediate Microeconomics","abbr":"","instructor":"Saran","url":"http://courses.yale-nus.edu.sg/"},
{"id":"12","MC":"5","type":"Elective","group":"SOCIAL SCIENCES","course":"Intro Math for Econ half-course 2 MC","abbr":"","instructor":"Saran","url":"http://courses.yale-nus.edu.sg/"}
]
-->