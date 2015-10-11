<script>
function copyToClipboard(elementId) {

  // Create a "hidden" input
  var aux = document.createElement("input");

  // Assign it the value of the specified element
  aux.setAttribute("value", document.getElementById(elementId).innerHTML);

  // Append it to the body
  document.body.appendChild(aux);

  // Highlight its content
  aux.select();

  // Copy the highlighted text
  document.execCommand("copy");

  // Remove it from the body
  document.body.removeChild(aux);

}
</script>


<p id="p1">P1: I am paragraph 1</p>
<p id="p2">P2: I am a second paragraph</p>
<button class="buttonstyle" onclick="copyToClipboard('p1')">Copy P1</button>
<button class="buttonstyle" onclick="copyToClipboard('p2')">Copy P2</button>
<br/><br/><input type="text" placeholder="Paste here for test" />

					<form>
				<ul class="formstyle">
					<li>
						<label>Direktlink1</label>
						<input id="p11" type="text" readonly name="event_link" class="feld-lang" value="P1: I am paragraph 1"/></input>
					</li>
					<li>
						<label>Direktlink2</label>
						<input id="p22" type="text" readonly name="event_link" class="feld-lang" value="P2: I am a second paragraph"/></input>
					</li>
					<li>
					<input type="text" placeholder="Paste here for test" />
					</li>
				</ul>
			</form>
			<button onclick="copyToClipboard('p11')">Copy P1</button>
			<button onclick="copyToClipboard('p22')">Copy P2</button>
<hr>

<form action="mailto:dasilva.patrik@gmail.com" method="post" name="Formular" enctype="text/plain">
Abesender:* <input type="text" name="absender" size=15><br>
Nachricht:* <textarea name="nachricht" rows="3" cols="25"></textarea><br>
<p><input type="submit" value="Abschicken"></form>
