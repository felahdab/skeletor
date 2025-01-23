@if ($row->lache_dans_fonction)
     <span class="text-success"><x-bootstrap-icon iconname='check-circle.svg'/></span><!--coche verte-->
@else
     <span class="text-danger"><x-bootstrap-icon iconname='x-circle.svg'/></span><!--croix rouge-->
@endif