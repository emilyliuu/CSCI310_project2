<div class="ui-widget">
  <label for="tags">Search: </label>
  <input id="tags" type="text" style="width:75%">
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