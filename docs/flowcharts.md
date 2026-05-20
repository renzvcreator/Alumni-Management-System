# Process Flowcharts — Mermaid Source

How to use:
1. Open https://mermaid.live
2. Delete the sample code on the left panel
3. Copy ONE flowchart block below (between the ```mermaid fences) and paste it
4. The diagram renders on the right
5. Click "Actions" -> "PNG" (or SVG) to download
6. Repeat for each flowchart


-------------------------------------------------------------------------------
5.1  USER REGISTRATION
-------------------------------------------------------------------------------

```mermaid
flowchart TD
    A([Start]) --> B[Visitor opens /register page]
    B --> C[Fill form + upload verification document]
    C --> D[Submit form]
    D --> E{Inputs valid?<br/>email, password,<br/>document}
    E -->|No| F[Show validation errors<br/>and stay on form]
    F --> Z([End])
    E -->|Yes| G[Save document to<br/>storage/public/verification]
    G --> H[Create user record<br/>status = pending<br/>role = alumni]
    H --> I[Create matching<br/>profile record]
    I --> J[Auto-login user]
    J --> K[Redirect to /pending page]
    K --> Z
```


-------------------------------------------------------------------------------
5.2  USER LOGIN
-------------------------------------------------------------------------------

```mermaid
flowchart TD
    A([Start]) --> B[User opens /login page]
    B --> C[Enter email and password]
    C --> D[Submit form]
    D --> E{Credentials valid?}
    E -->|No| F[Show 'Invalid login' error]
    F --> Z([End])
    E -->|Yes| G{Role = admin?}
    G -->|Yes| H[Redirect to /admin dashboard]
    H --> Z
    G -->|No| I{Status = approved?}
    I -->|Yes| J[Redirect to /dashboard]
    J --> Z
    I -->|Pending| K[Redirect to /pending page]
    K --> Z
    I -->|Blocked| L[Reject session<br/>show blocked message]
    L --> Z
```


-------------------------------------------------------------------------------
5.3  ADMIN APPROVAL (USER VERIFICATION)
-------------------------------------------------------------------------------

```mermaid
flowchart TD
    A([Start]) --> B[Admin opens /admin/users<br/>filter: pending]
    B --> C[Select a pending alumnus]
    C --> D[Review the uploaded<br/>verification document]
    D --> E{Document valid?}
    E -->|Yes| F[Click 'Approve']
    F --> G[Update user status<br/>to 'approved']
    G --> H[User can now log in<br/>as an alumnus]
    H --> Z([End])
    E -->|No| I[Click 'Reject']
    I --> J[Delete verification<br/>document from storage]
    J --> K[Delete user record]
    K --> Z
```


-------------------------------------------------------------------------------
5.4  ADDING DATA (CRUD) - ADMIN CREATES AN ANNOUNCEMENT
-------------------------------------------------------------------------------

```mermaid
flowchart TD
    A([Start]) --> B[Admin opens /admin/announcements]
    B --> C[Click 'New Announcement']
    C --> D[Fill title, content,<br/>optional cover image]
    D --> E[Click 'Save']
    E --> F{Inputs valid?}
    F -->|No| G[Show validation errors]
    G --> Z([End])
    F -->|Yes| H[Store image to disk<br/>if uploaded]
    H --> I[Insert row in announcements<br/>admin_id = current admin]
    I --> J[Redirect to list with<br/>success message]
    J --> K[Alumni see new announcement<br/>on /announcements and dashboard]
    K --> Z
```


-------------------------------------------------------------------------------
5.5  TRANSACTION - ALUMNI RSVP TO AN EVENT
-------------------------------------------------------------------------------

```mermaid
flowchart TD
    A([Start]) --> B[Alumnus opens /events page]
    B --> C[Select an event]
    C --> D[Click 'RSVP' button]
    D --> E{Already RSVP'd<br/>to this event?}
    E -->|Yes| F[Show 'RSVP'd' badge<br/>no action taken]
    F --> Z([End])
    E -->|No| G{Event archived<br/>or past date?}
    G -->|Yes| H[Block RSVP<br/>show error]
    H --> Z
    G -->|No| I[Insert row in event_user<br/>user_id, event_id,<br/>rsvp_at = now]
    I --> J[Dashboard 'My RSVPs'<br/>counter increases by 1]
    J --> K[Redirect to event page<br/>with confirmation badge]
    K --> Z
```
