<style>
    .table-scroll { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

    @media (max-width: 767.98px) {
        table.table-cards,
        table.table-cards tbody,
        table.table-cards tr,
        table.table-cards td { display: block; width: 100%; }

        table.table-cards thead {
            position: absolute; width: 1px; height: 1px; overflow: hidden;
            clip: rect(0 0 0 0); white-space: nowrap;
        }

        table.table-cards tr {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            margin-bottom: 12px;
            padding: 6px 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .05);
        }

        table.table-cards td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 9px 0;
            border: 0;
            border-bottom: 1px solid #f1f5f9;
            text-align: right;
            word-break: break-word;
        }
        table.table-cards td:last-child { border-bottom: 0; }

        table.table-cards td::before {
            content: attr(data-label);
            flex-shrink: 0;
            font-weight: 600;
            font-size: .8rem;
            color: #217a5f;
            text-align: left;
        }

        table.table-cards td.actions { justify-content: flex-start; flex-wrap: wrap; }
        table.table-cards td.actions::before { display: none; }
    }
</style>

<script>
    document.querySelectorAll('table.table-cards').forEach(function (table) {
        var headers = Array.from(table.querySelectorAll('thead th')).map(function (th) {
            return th.textContent.trim();
        });
        table.querySelectorAll('tbody tr').forEach(function (row) {
            row.querySelectorAll('td').forEach(function (cell, i) {
                if (!cell.hasAttribute('data-label') && headers[i]) {
                    cell.setAttribute('data-label', headers[i]);
                }
            });
        });
    });
</script>