<?php
// models.php
require_once 'core/dbConfig.php';

/**
 * Create a new applicant.
 */
function createApplicant($pdo, $data) {
    try {
        $sql = "INSERT INTO applicants (first_name, last_name, email, phone_number, specialization, years_experience) 
                VALUES (:first_name, :last_name, :email, :phone_number, :specialization, :years_experience)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'],
            ':specialization' => $data['specialization'],
            ':years_experience' => $data['years_experience'],
        ]);
        return [
            'message' => 'Applicant added successfully!',
            'statusCode' => 200
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to add applicant: ' . $e->getMessage(),
            'statusCode' => 400
        ];
    }
}

/**
 * Read all applicants (minimal details).
 */
function readApplicants($pdo) {
    try {
        $sql = "SELECT first_name, last_name FROM applicants";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'message' => 'Applicants fetched successfully.',
            'statusCode' => 200,
            'querySet' => $result
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to fetch applicants: ' . $e->getMessage(),
            'statusCode' => 400
        ];
    }
}

/**
 * Search applicants by various fields.
 */
function searchApplicants($pdo, $searchQuery) {
    try {
        $sql = "SELECT * FROM applicants 
                WHERE first_name LIKE :search 
                OR last_name LIKE :search 
                OR email LIKE :search 
                OR phone_number LIKE :search 
                OR specialization LIKE :search 
                OR years_experience LIKE :search";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'message' => 'Search completed successfully.',
            'statusCode' => 200,
            'querySet' => $result
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to search applicants: ' . $e->getMessage(),
            'statusCode' => 400
        ];
    }
}

/**
 * Update an applicant's details.
 */
function updateApplicant($pdo, $applicantId, $data) {
    try {
        $sql = "UPDATE applicants 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    email = :email, 
                    phone_number = :phone_number, 
                    specialization = :specialization, 
                    years_experience = :years_experience 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $applicantId,
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'],
            ':specialization' => $data['specialization'],
            ':years_experience' => $data['years_experience'],
        ]);
        return [
            'message' => 'Applicant updated successfully!',
            'statusCode' => 200
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to update applicant: ' . $e->getMessage(),
            'statusCode' => 400
        ];
    }
}

/**
 * Delete an applicant by ID.
 */
function deleteApplicant($pdo, $applicantId) {
    try {
        $sql = "DELETE FROM applicants WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $applicantId]);
        return [
            'message' => 'Applicant deleted successfully!',
            'statusCode' => 200
        ];
    } catch (Exception $e) {
        return [
            'message' => 'Failed to delete applicant: ' . $e->getMessage(),
            'statusCode' => 400
        ];
    }
}
