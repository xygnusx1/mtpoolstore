<!-- View stored in resources/views/cust/cust-home.blade.php -->
@extends('layouts.app')

@section('content')
<style>
    @media (prefers-color-scheme: dark) {
        .bg-dots {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(200,200,255,0.15)'/%3E%3C/svg%3E");
        }
    }

    @media (prefers-color-scheme: light) {
        .bg-dots {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,50,0.10)'/%3E%3C/svg%3E")
        }
    }
</style>

<div class="container">
    <div class="toppane">
        <div class="mx-auto bg-white rounded-lg shadow-md p-8">
            <div class="mb-4">
                <label for="filterInput" class="block text-gray-700 text-sm font-bold mb-2">Customer Name:</label>
                <input type="text" id="filterInput" placeholder="Enter a name to search..."
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div id="dropdown" class="dropdown-content">
                    <table>
                        <tbody id="dropdownTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex">
        <div class="leftpane">
        </div>

        <div id="mid-section" class="middlepane">
            <h2>Middle Test Page</h2>
            <!--            <textarea id="mid-section-text" style="width:100%;"></textarea>-->
            <div id="mid-section-html" style="width:100%;"></div>
        </div>

        <div id="right-section" class="rightpane">
            <h1>Right Test Page</h1>
            <img id="cust-image" alt="Fetched Image" width="300"/>
        </div>
    </div>
</div>


@endsection


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterInputFld = document.getElementById('filterInput');
        const custTable = document.getElementById("cust-table");
        custNames.sort();

        function getCustomerFromNas(name) {
            $.ajax({
                url: `/cust/${name}`,
                type: 'GET'
            }).done(function (data) {
                console.log(data);
                var html = '';
                // $('#mid-section-text').text(JSON.stringify(data, null, 2));
                $('#mid-section-html').html(jsonObjToHtml(data, `/storage/pap034cust/${name}`));
            })
        }

        function loadPDF(path) {
            let img = document.createElement('img');
            img.src = path;
            const parentEl = document.getElementById("right-section");
            parentEl.appendChild(img);
        }

        function jsonObjToHtml(obj, basePath) {
            var html = '<ul>';
            Object.keys(obj).forEach(function (k) {
                var v = obj[k];
                if (Array.isArray(v)) {
                    html += '<li><h3>' + k + '</h3>' + jsonArrayToHtml(v, `${basePath}/${k}`) + '</li>\n\r';
                } else if (typeof v === 'object') {
                    html += '<li><h3>' + k + '</h3>' + jsonObjToHtml(v, `${basePath}/${k}`) + '</li>\n\r';
                } else {
                    html += '<li>' + makeHtmlLinkForFilename(v, basePath) + '</li>\n\r';
                    // html += makeHtmlLinkForFilename(v, basePath);
                }
            });
            html += '</ul>';
            return html;
        }

        function jsonArrayToHtml(ary, basePath) {
            var imgCount = 0;
            var html = '<ul>';
            for (var i = 0; i < ary.length; i++) {
                let v = ary[i];
                if (Array.isArray(v)) {
                    html += '<li><h3>' + v + '</h3>' + jsonArrayToHtml(v, `${basePath}/${v}`) + '</li>\n\r';
                } else if (typeof v === 'object') {
                    html += '<li>' + jsonObjToHtml(v, `${basePath}/${v}`) + '</li>\n\r';
                }
                imgCount++;
                if (imgCount == 1) {
                    html += '<div style="display: flex; flex-wrap: wrap; gap:5px; width: 95%; ">';
                }
                // html += '<li>' + makeHtmlLinkForFilename(v, basePath) + '</li>';
                html += makeHtmlLinkForFilename(v, basePath);
                // html += makeHtmlLinkForFilename(v, basePath);
            }
            if (imgCount > 0) {
                html += "</div>";
            }
            html += '</ul>';
            return html;
        }

        function makeHtmlLinkForFilename(fn, baseUrl) {
            if (fn.endsWith('.JPG') || fn.endsWith('.PNG') || fn.endsWith('.JPEG')) {
                // atag = `<a href="javascript:loadPhoto('${baseUrl}/${fn}')">${fn}</a>`;
                atag = `<img src="${baseUrl}/${fn}" width="80"></img>`;
            } else if (fn.endsWith('.MOV')) {
                atag = `<video width="60" controls><source src="${baseUrl}/${fn}" type="video/mov"></video>`;
            } else if (fn.endsWith('.PDF')) {
                atag = `<a href="${baseUrl}/${fn}">${fn}</a>`;
            } else {
                atag = fn;
            }
            return atag;
        }

        // Dropdown functions
        const $filterInput = $('#filterInput');
        const $dropdown = $('#dropdown');
        const $dropdownTableBody = $('#dropdownTableBody');
        let highlightedIndex = -1; // To track the currently highlighted item

        // Function to filter data and populate the dropdown
        function filterAndShowDropdown() {
            const searchTerm = $filterInput.val().toUpperCase();
            $dropdownTableBody.empty(); // Clear previous results
            highlightedIndex = -1; // Reset highlight

            if (searchTerm.length === 0) {
                $dropdown.hide();
                return;
            }

            const filteredItems = custNames.filter(item =>
                item.includes(searchTerm)
            );

            if (filteredItems.length > 0) {
                filteredItems.forEach((item, index) => {
                    const row = $('<tr>')
                        .data('item-id', item) // Store the item ID
                        .append($('<td>').text(item))
                    // .append($('<td>').text(item.category));
                    $dropdownTableBody.append(row);
                });
                $dropdown.show();
            } else {
                $dropdown.hide();
            }
        }

        // Function to select an item
        function selectItem($row) {
            if ($row.length === 0) return;
            const selectedItem = $row.data('item-id');
            const itemData = custNames.find(item => item === selectedItem);
            if (itemData) {
                $filterInput.val(itemData); // Set input value to selected item's name
                console.log("Selected Item:", itemData); // Log the selected item
                $dropdown.hide();
                getCustomerFromNas(itemData);

            }
        }

        // Event listener for input field changes
        $filterInput.on('input', filterAndShowDropdown);

        // Keyboard navigation
        $filterInput.on('keydown', function (e) {
            const $rows = $dropdownTableBody.find('tr');
            if ($rows.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault(); // Prevent cursor movement
                highlightedIndex = (highlightedIndex + 1) % $rows.length;
                updateHighlight($rows);
                scrollToHighlighted($rows);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault(); // Prevent cursor movement
                highlightedIndex = (highlightedIndex - 1 + $rows.length) % $rows.length;
                updateHighlight($rows);
                scrollToHighlighted($rows);
            } else if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                if (highlightedIndex > -1) {
                    selectItem($rows.eq(highlightedIndex));
                } else if ($rows.length === 1 && $rows.eq(0).find('td:first').text().toUpperCase().indexOf($filterInput.val().toUpperCase()) >= 0) {
                    // If only one item and it matches the input exactly, select it
                    selectItem($rows.eq(0));
                } else {
                    getCustomerFromNas($filterInput.val());
                }
                $dropdown.hide();
            } else if (e.key === 'Escape') {
                $dropdown.hide();
                highlightedIndex = -1;
            }
        });

        // Update highlight class
        function updateHighlight($rows) {
            $rows.removeClass('highlighted');
            if (highlightedIndex > -1) {
                $rows.eq(highlightedIndex).addClass('highlighted');
            }
        }

        // Scroll to highlighted item
        function scrollToHighlighted($rows) {
            if (highlightedIndex > -1) {
                const $highlightedRow = $rows.eq(highlightedIndex);
                const dropdownHeight = $dropdown.height();
                const rowTop = $highlightedRow.position().top;
                const rowHeight = $highlightedRow.outerHeight();

                if (rowTop < 0) {
                    // Scroll up
                    $dropdown.scrollTop($dropdown.scrollTop() + rowTop);
                } else if (rowTop + rowHeight > dropdownHeight) {
                    // Scroll down
                    $dropdown.scrollTop($dropdown.scrollTop() + rowTop + rowHeight - dropdownHeight);
                }
            }
        }

        // Click event for dropdown items
        $dropdownTableBody.on('click', 'tr', function () {
            selectItem($(this));
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.autocomplete-wrapper').length) {
                $dropdown.hide();
                highlightedIndex = -1;
            }
        });
    });

    <?php
    //    echo 'const baseCustDir = "' . $custdbBaseDir . '";';
    echo 'const custNames = [';
    $count = 0;
    foreach (new DirectoryIterator($custdb_active) as $file) {
        if ($file->isDot()) continue;
        if ($file->getFilename()[0] == "_") continue;
        if (!$file->isDir()) continue;
        $dirName = strtoupper($file->getFilename());
        if ($count == 0)
            echo "'", $dirName, "'";
        else
            echo ",'", $dirName, "'";
        $count++;
    }
    foreach (new DirectoryIterator($custdb_done) as $file) {
        if ($file->isDot()) continue;
        if ($file->getFilename()[0] == "_") continue;
        if (!$file->isDir()) continue;
        $dirName = strtoupper($file->getFilename());
        if ($count == 0)
            echo "'", $dirName, "'";
        else
            echo ",'", $dirName, "'";
        $count++;
    }
    echo "];\n";
    ?>
</script>
