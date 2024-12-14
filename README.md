# Laravel Developer Pre-Interview Test

## Instructions

1. Fork this repository or clone and complete the test.
2. Inside the `public` directory, you will find an `HTML` directory containing an HTML template. Use this template to build the front end for CRUD operations.
3. Submit your solution as a GitHub repository link or a compressed file with your code.
4. Ensure your code is well-structured, follows best practices, and includes comments where necessary.

## Test Requirements

### 1. Country-State-City CRUD with SQL Relationships and AJAX

- **Task**: Create a CRUD application for managing **countries**, **states**, and **cities** with the following requirements:
    - A **country** can have multiple **states**.
    - Each **state** can have multiple **cities**.
    - Implement proper relationships between these models using SQL (foreign keys).
- **Endpoints Required**:
    - **Country**: `Create`, `Read`, `Update`, `Delete`
    - **State**: `Create`, `Read`, `Update`, `Delete`
    - **City**: `Create`, `Read`, `Update`, `Delete`
- **AJAX Requirements**:
    - All CRUD operations must be implemented using AJAX to handle data asynchronously.
    - Display success/error messages without page reloads.
- **Notes**:
    - Use SQL relationships to manage associations between tables.
    - Ensure that **country** or **state** cascades are deleted from associated **states** and **cities** as appropriate.

### 2. General Guidelines

- Use **Laravel 11**.
- **Code Quality**: Ensure clean, readable, and maintainable code.
- **Comments**: Add comments explaining complex logic or unique solutions.
- **Testing**: Add basic tests to verify that AJAX CRUD operations work as expected.

## Bonus Points

- **Validation Rules**: Use validation rules for each AJAX form submission (e.g., required fields, format validation).

