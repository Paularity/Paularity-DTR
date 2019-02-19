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

function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('datetime', 'Time of Day');
    data.addColumn('number', 'Motivation Level');

    data.addRows([
      [new Date(2019, 2, 06, 10,01,00,00), 1],    
      [new Date(2019, 3, 06, 10,05,00,00), 2],    
      [new Date(2019, 4, 06, 10,07,00,00), 3],    
      [new Date(2019, 5, 06, 09,01,00,00), 4],    
      [new Date(2019, 6, 06, 10,11,00,00), 5],    
    ]);

    var options = {
      width: 900,
      height: 500,
      legend: {position: 'none'},
      enableInteractivity: false,
      chartArea: {
        width: '85%'
      },
      hAxis: {
        viewWindow: {
          min: new Date(2019, 01, 00),
          max: new Date(2019, 12, 31)
        },
        gridlines: {
          count: -1,
          units: {
            days: {format: ['MMM dd']},
            hours: {format: ['HH:mm', 'ha']},
          }
        },
        minorGridlines: {
          units: {
            hours: {format: ['hh:mm:ss a', 'ha']},
            minutes: {format: ['HH:mm a Z', ':mm']}
          }
        }
      }
    };

    var chart = new google.visualization.LineChart(
      document.getElementById('chart_div'));

    chart.draw(data, options);

    var button = document.getElementById('change');
    var isChanged = false;
  }