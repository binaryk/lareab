<li>                                    
<a href="#"> Achiziții <span class="fa arrow"></span></a>
<ul class="nav nav-second-level">
    <li>                                    
        <a href="{{ \URL::route('datatable-index', ['id' => 'tip-achizitii']) }}">Tip achiziții</a>
    </li> 
    <li>                                    
        <a href="{{ \URL::route('datatable-index', ['id' => 'proceduri-achizitii']) }}">Modalități de publicare</a>
    </li>  
    <li>                                    
        <a href="{{ \URL::route('datatable-index', ['id' => 'clasificare-documente']) }}">Clasificare documente</a>
    </li>  
    <li>                                    
        <a href="{{ \URL::route('nomenclator-template-achizitii', ['id' => 'template-achizitii']) }}">Template achiziții</a>
    </li>     
</ul>
</li>
<li>
    <a href="{{ URL::route('proiecte-index') }}">Proiecte</a>
</li>