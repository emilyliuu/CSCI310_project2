<br><br><br>
<div class="ui-widget">
	Enter a ticker symbol below:<br>
	<input id="tags" type="text">
</div>

<script>
  $(function() {
    var availableTags = [
      "MSFT",
	  "FB",
	  "AAPL",
	  "GOOG",
	  "BRK.A",
	  "AMZN",
	  "TSLA"
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
</script>