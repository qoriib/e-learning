<?php
/**
 * Simple pagination helper for mysqli queries.
 * Usage: $meta = paginate_query($conn, $sql, $page);
 * - $sql: base query without trailing semicolon
 * - returns ['result','total','page','pages','per_page','offset']
 */
function paginate_query(mysqli $conn, string $baseQuery, int $page = 1, int $perPage = 30): array
{
    $page = max(1, $page);
    $perPage = max(1, $perPage);
    $offset = ($page - 1) * $perPage;

    $countSql = "SELECT COUNT(*) AS total FROM ($baseQuery) AS base_count";
    $countRes = mysqli_query($conn, $countSql);
    $total = 0;
    if ($countRes && $row = mysqli_fetch_assoc($countRes)) {
        $total = (int)$row['total'];
    }

    $query = $baseQuery . " LIMIT $perPage OFFSET $offset";
    $result = mysqli_query($conn, $query);

    $pages = $total > 0 ? (int)ceil($total / $perPage) : 1;

    return [
        'result'   => $result,
        'total'    => $total,
        'page'     => $page,
        'pages'    => $pages,
        'per_page' => $perPage,
        'offset'   => $offset,
    ];
}

function render_pagination(string $baseUrl, array $meta, array $params = []): string
{
    if ($meta['pages'] <= 1) {
        return '';
    }

    $qs = function ($page) use ($params) {
        return http_build_query(array_merge($params, ['page' => $page]));
    };

    $prevLink = $meta['page'] > 1
        ? '<a href="' . $baseUrl . '?' . $qs($meta['page'] - 1) . '">&laquo; Prev</a>'
        : '<span class="disabled">&laquo; Prev</span>';
    $nextLink = $meta['page'] < $meta['pages']
        ? '<a href="' . $baseUrl . '?' . $qs($meta['page'] + 1) . '">Next &raquo;</a>'
        : '<span class="disabled">Next &raquo;</span>';

    return '<div class="pagination">' .
        $prevLink .
        '<span class="page-indicator">Halaman ' . $meta['page'] . ' dari ' . $meta['pages'] . '</span>' .
        $nextLink .
        '</div>';
}
