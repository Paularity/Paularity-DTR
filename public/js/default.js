function hideAlert( x )
{
    $( x ).fadeOut( "slow", function() 
    {
        setTimeout(function(){ $(x).remove(); }, 3000);
    });        
}

function confirmSubmit( msg )
{
    var dialog = confirm( msg );
    if (dialog == true) 
    {
        return true;
    }
    else 
    {
      return false;
    }
}

function filterizeSearch()
{
    $("#filterInput").on("keyup", function() 
    {
      var value = $(this).val().toLowerCase();
      $("#filterTable tr").filter(function() 
      {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
}
