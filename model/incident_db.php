<?php
// model/incident_db.php
// Purpose: Database operations for incidents

require_once(__DIR__ . '/../util/db_error.php');

function get_open_incidents(): array
{
    global $db;

    try {
        $query = '
            SELECT
                i.incidentID,
                i.dateOpened,
                i.title,
                i.customerID,
                i.productID,
                i.techID,
                c.firstName AS customerFirstName,
                c.lastName  AS customerLastName,
                p.name      AS productName,
                t.firstName AS techFirstName,
                t.lastName  AS techLastName
            FROM incidents i
            JOIN customers c ON i.customerID = c.customerID
            JOIN products  p ON i.productID  = p.productID
            LEFT JOIN technicians t ON i.techID = t.techID
            WHERE i.dateClosed IS NULL
            ORDER BY i.dateOpened DESC, i.incidentID DESC
        ';

        $statement = $db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load open incidents.', $e);
        return [];
    }
}

/**
 * ✅ Project 20-2: ONLY unassigned + open incidents (techID IS NULL)
 */
function get_unassigned_open_incidents(): array
{
    global $db;

    try {
        $query = '
            SELECT
                i.incidentID,
                i.dateOpened,
                i.title,
                c.firstName AS customerFirstName,
                c.lastName  AS customerLastName,
                p.name      AS productName
            FROM incidents i
            JOIN customers c ON i.customerID = c.customerID
            JOIN products  p ON i.productID  = p.productID
            WHERE i.dateClosed IS NULL
              AND i.techID IS NULL
            ORDER BY i.dateOpened DESC, i.incidentID DESC
        ';

        $statement = $db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load unassigned incidents.', $e);
        return [];
    }
}

/**
 * Get one incident with customer + product + technician info
 */
function get_incident(int $incident_id): array|false
{
    global $db;

    try {
        $query = '
            SELECT
                i.incidentID,
                i.dateOpened,
                i.dateClosed,
                i.title,
                i.description,
                i.customerID,
                i.productID,
                i.techID,
                c.firstName AS customerFirstName,
                c.lastName  AS customerLastName,
                c.email     AS customerEmail,
                p.name      AS productName,
                t.firstName AS techFirstName,
                t.lastName  AS techLastName
            FROM incidents i
            JOIN customers c ON i.customerID = c.customerID
            JOIN products  p ON i.productID  = p.productID
            LEFT JOIN technicians t ON i.techID = t.techID
            WHERE i.incidentID = :incident_id
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':incident_id', $incident_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load incident details.', $e);
        return false;
    }
}

/**
 * Assign a technician to an incident
 */
function assign_incident(int $incident_id, int $tech_id): void
{
    global $db;

    try {
        $query = '
            UPDATE incidents
            SET techID = :tech_id
            WHERE incidentID = :incident_id
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':tech_id', $tech_id, PDO::PARAM_INT);
        $statement->bindValue(':incident_id', $incident_id, PDO::PARAM_INT);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to assign technician to incident.', $e);
    }
}

/**
 * Close an incident (sets dateClosed to NOW())
 */
function close_incident(int $incident_id): void
{
    global $db;

    try {
        $query = '
            UPDATE incidents
            SET dateClosed = NOW()
            WHERE incidentID = :incident_id
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':incident_id', $incident_id, PDO::PARAM_INT);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to close incident.', $e);
    }
}

/**
 * Get open incidents assigned to a specific technician
 */
function get_open_incidents_by_technician(int $techID): array
{
    global $db;

    try {
        $query = 'SELECT i.incidentID, i.dateOpened, i.title,
                         c.firstName AS customerFirstName, c.lastName AS customerLastName,
                         p.name AS productName
                  FROM incidents i
                  JOIN customers c ON i.customerID = c.customerID
                  JOIN products p ON i.productID = p.productID
                  WHERE i.techID = :techID AND i.dateClosed IS NULL
                  ORDER BY i.dateOpened DESC';

        $statement = $db->prepare($query);
        $statement->bindValue(':techID', $techID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load technician incidents.', $e);
        return [];
    }
}

function incident_belongs_to_technician(int $incidentID, int $techID): bool
{
    global $db;

    try {
        $query = 'SELECT 1
                  FROM incidents
                  WHERE incidentID = :incidentID AND techID = :techID';

        $statement = $db->prepare($query);
        $statement->bindValue(':incidentID', $incidentID, PDO::PARAM_INT);
        $statement->bindValue(':techID', $techID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn() !== false;

    } catch (PDOException $e) {
        show_database_error('Unable to validate incident ownership.', $e);
        return false;
    }
}

/**
 * Update incident description and optionally close it (technician-only)
 * - Only allows update if incident belongs to the technician
 * - dateClosed can be NULL (keep open) or YYYY-MM-DD
 */
function update_incident_description_and_close_date(
    int $incidentID,
    int $techID,
    string $description,
    ?string $dateClosed
): void {
    global $db;

    try {
        // Only update incidents owned by this tech (extra safety)
        if ($dateClosed === null) {
            $query = 'UPDATE incidents
                      SET description = :description,
                          dateClosed = NULL
                      WHERE incidentID = :incidentID
                        AND techID = :techID';
        } else {
            $query = 'UPDATE incidents
                      SET description = :description,
                          dateClosed = :dateClosed
                      WHERE incidentID = :incidentID
                        AND techID = :techID';
        }

        $statement = $db->prepare($query);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':incidentID', $incidentID, PDO::PARAM_INT);
        $statement->bindValue(':techID', $techID, PDO::PARAM_INT);

        if ($dateClosed !== null) {
            $statement->bindValue(':dateClosed', $dateClosed);
        }

        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to update incident.', $e);
    }
}

/**
 * Project 20-4: Unassigned incidents (techID IS NULL)
 */
function get_unassigned_incidents(): array
{
    global $db;

    try {
        $query = '
            SELECT
                i.incidentID,
                i.dateOpened,
                i.dateClosed,
                i.title,
                c.firstName AS customerFirstName,
                c.lastName  AS customerLastName,
                p.name      AS productName
            FROM incidents i
            JOIN customers c ON i.customerID = c.customerID
            JOIN products  p ON i.productID  = p.productID
            WHERE i.techID IS NULL
            ORDER BY i.dateOpened DESC, i.incidentID DESC
        ';

        $statement = $db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load unassigned incidents.', $e);
        return [];
    }
}

/**
 * Project 20-4: Assigned incidents (techID IS NOT NULL)
 * - Must show technician name
 * - Must show "OPEN" if dateClosed is NULL
 */
function get_assigned_incidents(): array
{
    global $db;

    try {
        $query = '
            SELECT
                i.incidentID,
                i.dateOpened,
                i.dateClosed,
                i.title,
                c.firstName AS customerFirstName,
                c.lastName  AS customerLastName,
                p.name      AS productName,
                t.firstName AS techFirstName,
                t.lastName  AS techLastName
            FROM incidents i
            JOIN customers c ON i.customerID = c.customerID
            JOIN products  p ON i.productID  = p.productID
            JOIN technicians t ON i.techID   = t.techID
            WHERE i.techID IS NOT NULL
            ORDER BY i.dateOpened DESC, i.incidentID DESC
        ';

        $statement = $db->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        show_database_error('Unable to load assigned incidents.', $e);
        return [];
    }
}

function add_incident(int $customer_id, int $product_id, string $title, string $description): void
{
    global $db;

    try {
        $query = '
            INSERT INTO incidents
                (customerID, productID, techID, dateOpened, dateClosed, title, description)
            VALUES
                (:customerID, :productID, NULL, NOW(), NULL, :title, :description)
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':customerID', $customer_id, PDO::PARAM_INT);
        $statement->bindValue(':productID',  $product_id,  PDO::PARAM_INT);
        $statement->bindValue(':title',      $title);
        $statement->bindValue(':description',$description);
        $statement->execute();

    } catch (PDOException $e) {
        show_database_error('Unable to create incident.', $e);
    }
}