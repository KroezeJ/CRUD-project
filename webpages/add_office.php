<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../includes/header.php';
    include '../includes/admincheck.php';
    ?>
    <title>Project3</title>
</head>

<body>
    <?php include '../includes/navbar.php';
    ?>

    <div class="container mt-5">
        <h2>Add Office</h2>
        <form method="post" action="../includes/newentry.php?add=office">
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <div class="input-group">
                    <input type="text" class="form-control text-center" id="phoneCode" name="phoneCode" readonly>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="e.g. 6 123 456 78" maxlength="255" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="addressLine1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" id="addressLine1" name="addressLine1" placeholder="e.g. Makebelief Street 123" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="addressLine2" class="form-label">Address Line 2</label>
                <input type="text" class="form-control" id="addressLine2" placeholder="e.g. Makebelief Street 123" name="addressLine2" maxlength="255">
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-control" id="country" name="country" required>
                </select>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <select class="form-control" id="state" name="state">
                </select>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <select class="form-control" id="city" name="city">
                </select>
            </div>
            <div class="mb-3">
                <label for="postalCode" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="e.g. 165832" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="territory" class="form-label">Territory</label>
                <input type="text" class="form-control" id="territory" name="territory" placeholder="e.g. Gemeente Amsterdam" maxlength="255" required>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function() {
            const countryUrl = 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json';

            $.getJSON(countryUrl, function(data) {
                const countries = data;

                // Initialize select2 for country, state, and city
                $('#country').select2({
                    data: countries.map(function(country) {
                        return {
                            id: country.name,
                            text: country.name,
                            states: country.states,
                            phone_code: country.phone_code
                        };
                    }),
                    placeholder: 'Select a country',
                }).val(null).trigger('change');

                $('#state').select2({
                    placeholder: 'Select a state',
                });

                $('#city').select2({
                    placeholder: 'Select a city',
                });

                // Update the state dropdown when a country is selected
                $('#country').on('select2:select', function(e) {
                    let selectedCountry = e.params.data;
                    let stateOptions = selectedCountry.states.map(function(state) {
                        return {
                            id: state.name,
                            text: state.name,
                            cities: state.cities,
                        };
                    });

                    $('#state').empty().select2({
                        data: stateOptions,
                        placeholder: 'Select a state',
                    });

                    $('#city').val(null).trigger('change');
                });

                // Update the city dropdown when a state is selected
                $('#state').on('select2:select', function(e) {
                    let selectedState = e.params.data;
                    let cityOptions = selectedState.cities.map(function(city) {
                        return {
                            id: city.name,
                            text: city.name,
                        };
                    });

                    $('#city').empty().select2({
                        data: cityOptions,
                        placeholder: 'Select a city',
                    });
                });

                $('#country').on('select2:select', function(e) {
                    let selectedCountry = e.params.data;
                    if (selectedCountry.phone_code[0] === "+") {
                        $('#phoneCode').val(selectedCountry.phone_code);
                    } else {
                        $('#phoneCode').val("+" + selectedCountry.phone_code);
                    }
                });
            });
        });
    </script>




    <?php include '../includes/footer.php'; ?>

</body>

</html>