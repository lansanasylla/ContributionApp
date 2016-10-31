<?php          
    try{ 
        $select = $bdd-> prepare('SELECT * FROM  contributors ');
        $select->execute();
        
        if($select->rowCount()>0){

            $tmpt = $select ->fetchAll();
          
    }else{
        echo"Aucun contributeur pour le moment ";
        }
    }catch(Exception $e){ 
        die('Erreur : '.$e->getMessage());
        }
?>
<script type="text/javascript">
    var data = <?php echo json_encode($tmpt); ?>;                            

</script>

<div class="row" ng-controller="listController">  
    <div class="col-sm-12 col-md-9">
        <h2 class="list-header">Contributors List</h2>
        <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr>
                <th>Date</th>
                <th>Names</th>
                <th>Number</th>
                <th>Amount</th>
                <th>Localité</th>
                <th>Collector</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="val in range(start,end,donneeFiltre)">
                    <td>{{val.Date_Contributors}}</td>
                    <td>{{val.First_Name}} {{val.Last_Name}}</td>
                    <td>{{val.Numbers}}</td>
                    <td>{{val.Amount | currency:"GNF "}}</td>
                    <td>{{val.Receiver}}</td>
                    <td>{{val.collector}}</td>
                </tr>
            </tbody> 
            </table>
        </div>
        <nav aria-label="...">
            <ul class="pager">
                <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span>Previous</a></li>
                <li class="center">{{currentPage}}/{{TotalPage}}</li>
                <li class="next"><a href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
    <div class="col-sm-12 col-md-3 side-bar">
        <h3>Filtre</h3>
        <a id="addfilter" href="/">Ajouter un filtre</a>
        <ul id="newFiltre">
        
        </ul>
        <form id="filterForm" style="display:none;">
            
            <div>
            <label>Champ</label>
            <select id="filteropt" name="filter">
                <option value="Donateur">Donators</option>
                <option value="Date">Date</option>
                <option value="Localité">Localité</option>
                <option value="Collector">Collector</option>
            </select>
            </div>
            <div id ="filterType" style="display:none;">
            <label>Type de Filtre</label>
                <select id="filterType-1" name="filterType">
                    <option value="Valeur">Valeur</option>
                    <option value="Intervalle">Intervalle</option>
                </select>
            </div>
            <div>
                <label class="opt-1" for="opt-1">Valeur </label><br />
                <input type="text" name="opt-1"> 
                <label class="opt-2" for="opt-2" style="display:none;" > au </label>
                <input class="opt-2" type="text" name="opt-2" style="display:none;">
            </div>
            <button id="newfilter" type="submit" class="btn btn-default">Ajouter</button>
        </form>
    </div>
</div>
