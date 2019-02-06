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
