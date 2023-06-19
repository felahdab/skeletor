@if ($row->comete == 0)
     <span class="text-danger"><x-bootstrap-icon iconname='x-circle.svg'/></span><!--croix rouge-->
@else
     <span class="text-success"><x-bootstrap-icon iconname='check-circle.svg'/></span><!--coche verte-->
@endif