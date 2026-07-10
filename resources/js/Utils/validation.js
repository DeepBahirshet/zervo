export function getFormErrors(error)
{
    return Object.fromEntries(
        error.issues.map(issue => [issue.path[0], issue.message])
    );
}