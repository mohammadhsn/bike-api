## Bike api

- The Police want to be more efficient in resolving stolen bike cases. They decided to build a software that can automate their processes
  — the software that you're going to develop.
- Requirements
  - Bike owners can report a stolen bike.
  - A bike can have multiple characteristics: license number, color, type, full name of the owner, date, and description of the theft.
  - The Police can increase or decrease the number of police officers.
  - Each police officer should be able to search bikes by different characteristics in a database and see which police officer is responsible for a stolen bike case.
  - New stolen bike cases should be automatically assigned to any free police officer.
  - A police officer can only handle one stolen bike case at a time.
  - When the Police find a bike, the case is marked as resolved and the responsible police officer becomes available to take a new stolen bike case.
  - The system should be able to assign unassigned stolen bike cases automatically when a police officer becomes available.
- Your task is to provide APIs for a frontend application that satisfies all requirements above.

- Please stick to the Product Requirements.
  You should not implement authorization and authentication. Assume everyone can make requests to any api.

- Scope

  - API Development (BP)
  - Transaction (CC)
  - Audit log
  - Unit / Integration

- Extra

  - publish client package (part of release)
  - stub
  - clean architecture

- Discussion
  - Design ?
