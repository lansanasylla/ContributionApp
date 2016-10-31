<form name="donatorForm" class="form-contribute" action="contribute.php" method='POST' ng-controller="donatorController" novalidate>
    <h2 class="form-contribute-heading">Contribution Froms</h2>

    <div class="form-group" ng-class="{ 'has-error':donatorForm.dat.$invalid && !donatorForm.dat.$pristine }">
        <span>Date (jj/mm/aaaa):</span>
        <input type="date" name='dat'  class="form-control" ng-model="dat" ui-date autofocus>
        <p ng-show="donatorForm.test.$invalid && !donatorForm.test.$pristine" class="help-block">La date est requise.</p>
    </div>
    
    <div class="form-group" ng-class="{'has-error':donatorForm.firstName.$invalid && !donatorForm.firstName.$pristine}">
        <span>Prenoms du contributeur:</span>
        <input type="text" name='firstName' class="form-control" placeholder="Prenoms du Contributeur" ng-model="firstName" required>
        <p ng-show="donatorForm.firstName.$invalid && !donatorForm.firstName.$pristine" class="help-block">Le prenom du donateur est requis.</p>
    </div>
    
    <div class="form-group" ng-class="{'has-error':donatorForm.lastName.$invalid && !donatorForm.lastName.$pristine}">
        <span>nom du contributeur:</span>
        <input type="text" name='lastName' class="form-control" placeholder="Nom du Contributeur" ng-model="lastName" required>
        <p ng-show="donatorForm.lastName.$invalid && !donatorForm.lastName.$pristine" class="help-block">Le nom du donateur est requis.</p>
    </div>

    <div class="form-group" ng-class="{'has-error':donatorForm.numbers.$invalid && !donatorForm.numbers.$pristine}">
        <span>Téléphone du contributeur:</span>
        <div class="input-group" id="number">
            <span class="input-group-addon">+224</span>
            <input type="number" name='numbers' class="form-control" ng-model="numbers" placeholder="Numero de Téléphone" aria-describedby="number" ng-minlength="9" ng-maxlength="9">
        </div>
        <p ng-show="donatorForm.numbers.$error.minlength" class="help-block">le numero est trop court.</p>
        <p ng-show="donatorForm.numbers.$error.maxlength" class="help-block">le numero est trop long.</p>
    </div>
    
    <div class="form-group" ng-class="{'has-error': donatorForm.location.$invalid && !donatorForm.location.$pristine}">
        <span>Location:</span>
        <select name="location" class="form-control">
            <option value="Timbi tounni">Timbi tounni</option>
            <option value="Bendekoure">Bendekoure</option>
            <option value="Diaga">Diaga</option>
            <option value="Diongassi">Diongassi</option>
            <option value="Horê Wouri">Horê Wouri</option>
            <option value="Kothyou">Kothyou</option>
            <option value="Pellel Missira">Pellel Missira</option>
            <option value="Pellel Bantan">Pellel Bantan</option>
            <option value="Saran">Saran</option>
        </select>
        <p ng-show="donatorForm.location.$invalid && !donatorForm.location.$pristine" class="help-block">Le localite est requise.</p>
    </div>
    
    <div class="form-group" ng-class="{'has-error' : donatorForm.amount.$invalid && !donatorForm.amount.$pristine}">
        <span>Montant:</span>
        <div class="input-group" id="amount">
            <input type="number" name='amount' placeholder="Montant de la contribution" aria-describedby="amount" class="form-control" ng-model="amount"  required>
            <span class="input-group-addon">GNF</span>
        </div>
        <p ng-show="donatorForm.amount.$invalid && !donatorForm.amount.$pristine" class="help-block">Le montant est requis.</p>
    </div>
            

    <button class="btn btn-lg btn-cancel" type="reset">Cancel</button>
    <button class="btn btn-lg btn-success" type="submit">Validate</button>
</form>