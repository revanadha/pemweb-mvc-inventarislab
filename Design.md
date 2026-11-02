# Design Specification: INVENTORY Management Dashboard

## 1. Executive Summary & Design System Overview

**INVENTORY** is an enterprise-grade, cloud-based back-office platform optimized for warehouse operations, multichannel e-commerce integration, and real-time inventory tracking.

The interface adheres to a **Contemporary Dark Mode Design System (Dark Slate & Neon Mint)**. This aesthetic minimizes ocular fatigue during prolonged analytical sessions, maximizes data density and tabular legibility, and emphasizes critical operational indicators via high-contrast accenting.

---

## 2. Design Tokens & Foundations

### 2.1 Color Palette

The color hierarchy is engineered using cool slate/teal dark neutrals complemented by high-luminance functional accents:

| Token Name | Hex Code | Purpose & Application |
| :--- | :--- | :--- |
| `color-bg-base` | `#11181C` | Canvas/application root background |
| `color-surface-sidebar` | `#162024` | Primary navigation sidebar surface |
| `color-surface-card` | `#1A262B` | Data table container & main content surface |
| `color-surface-hover` | `#202F36` | Table row hover & secondary button hover states |
| `color-primary` | `#00E599` | Primary brand accent, active states, key interactive links |
| `color-primary-subtle` | `#00E5991A` | 10% opacity primary fill for selected item backgrounds |
| `color-text-main` | `#FFFFFF` | Primary headings, table header titles, highlighted text |
| `color-text-muted` | `#8C9DA6` | Secondary body text, neutral icons, metadata, inactive links |
| `color-border` | `#26373F` | Grid dividers, table horizontal rules, outline containers |
| `color-indicator-accent`| `#00D287` | Stock status highlights, multi-warehouse deep links |

### 2.2 Typography Scale

* **Primary Font Family:** `Inter`, `SF Pro Display`, or system default sans-serif.
* **Typographic Hierarchy:**
  * **Page Heading (H1):** `20px` / Bold (700) / Line-height `28px` / `#FFFFFF`
  * **Section Heading (H2):** `16px` / SemiBold (600) / Line-height `24px` / `#FFFFFF`
  * **Body Medium / Table Cells:** `13px` / Medium (500) / Line-height `18px` / `#FFFFFF`
  * **Metadata / Auxiliary Text:** `12px` / Regular (400) / Line-height `16px` / `#8C9DA6`
  * **Micro-copy / Badges:** `11px` / Medium (500) / Line-height `14px` / `#00E599`

### 2.3 Spatial System & Elevation

* **Spacing Grid:** 4px baseline system (`4px`, `8px`, `12px`, `16px`, `24px`, `32px`).
* **Corner Radii:**
  * Master Container / Card Wrappers: `16px`
  * Input Fields & Action Buttons: `8px`
  * Product Thumbnails: `6px`
  * Active Navigation Pill: `8px`
* **Elevation & Ambient Glows:**
  * Card Drop Shadow: `0px 12px 32px rgba(0, 0, 0, 0.40)`
  * Focus / Active Indicator Glow: `0px 0px 14px rgba(0, 229, 153, 0.20)`

---

## 3. Information Architecture & Spatial Wireframe

```
+------------------------------------------------------------------------------------+
| SIDEBAR NAV (240px) | MAIN CONTENT AREA                                            |
|                     +--------------------------------------------------------------+
| [Logo: N INVENTORY] | TOP BAR: [ Search Input (360px) ]          [Alerts] [Avatar] |
|                     +--------------------------------------------------------------+
| * Primary Nav       | HEADER: "Dashboard"      [Action v] [List Marketplace >] [+] |
|  - Dashboard (act.) +--------------------------------------------------------------+
|  - Inventory        | DATA TABLE CONTAINER                                         |
|  - Marketplace      | [x] SKU | Image | Title | Cat | Qty | Warehouse | Price | ...|
|  - Orders           | ------------------------------------------------------------ |
|  - Shipping         | [ ] MRP400 | [img] | Winter Jacket ... | 22 | multiple 22... |
|  - Reports          | [ ] MRP405 | [img] | ABCD Western  ... | 35 | Loc A: 5...    |
|                     | [ ] ...                                                      |
| * Bottom Utility    |                                                              |
|  - Settings / Help  |                                                              |
+---------------------+--------------------------------------------------------------+
```

---

## 4. Component Specifications

### 4.1 Global Top Bar
* **Universal Search Bar:**
  * Width: ~360px, rounded corners (`8px`), border: `1px solid #26373F`.
  * Leading/Trailing search icon (`#8C9DA6`), placeholder: `"Search"`.
* **Utility Group:**
  * **Notification Bell:** Outlined icon with a live count badge pill (`#00E599` fill, dark text).
  * **User Profile Avatar:** 36px circular avatar with subtle 1px border.

### 4.2 Sidebar Navigation
* **Brand Header:**
  * High-visibility neon brand mark `N` accompanied by `INVENTORY` logotype.
  * Sidebar toggle collapse button anchored to the right edge.
* **Core Navigation Links:**
  * Navigation items: `Dashboard` (Active), `Inventory`, `Marketplace`, `Orders`, `Shipping`, `Reports`.
  * **Active Item Styling:** Elevated pill with a left border highlight, light teal fill (`#00E5991A`), and active mint icon/typography (`#00E599`).
* **Utility Navigation (Bottom Anchored):**
  * `Settings`, `Activity & Inventory`, `What's New`, `Help & Support`, `Log Out`.

### 4.3 Action Toolbar
Anchored to the right of the primary view heading (`Dashboard`):
1. **Dropdown Menu (`Action`):** Bulk actions (e.g., Export CSV, Archive, Batch Edit).
2. **Secondary Flow Button (`List on Marketplace`):** Opens modal/stepper to syndicate inventory to third-party marketplaces.
3. **Primary CTA (`Add New`):** High-priority trigger for manual SKU entry.

### 4.4 Inventory Data Table (High-Density View)

| Column Field | Type & Element | Text Alignment | Functional Details |
| :--- | :--- | :--- | :--- |
| **Selection** | Checkbox (`18x18px`) | Center | Bulk select checkbox (indeterminate support). |
| **SKU** | Monospace text + Badge | Left | Primary SKU identifier (e.g., `MRP400`). Parent SKUs feature a sub-variant counter (e.g., `Variation (4)` in mint). |
| **Image** | Thumbnail (`36x36px`) | Center | Fixed-ratio product preview with subtle border. |
| **Title** | Dual-line link text | Left | Mint-colored interactive link (`#00E599`) navigating directly to product edit screen. |
| **Category** | Text label | Left | Standard categorization (e.g., `Clothing`, `Boots`, `Footwear`). |
| **QTY** | Numeric integer | Left / Center | Real-time on-hand physical stock quantity. |
| **Warehouse** | Text link / Indicator | Left | Specific slot (`Location A: 5`) or aggregate indicator (`multiple 22`) for multi-facility distribution. |
| **Price** | Monospace currency | Right / Left | Unit MSRP/Selling Price (e.g., `$223.20`). |
| **Last Modified**| Stacked timestamp | Left | Stacked format: Time (`1.00 Pm`) on line 1, date (`Aug 10, 2024`) on line 2. |
| **Status / Quick Edit** | Status token + Icon | Right | Status identifier (`ACCO`, `11SE`, `CACO`) paired with inline pencil action icon. |

---

## 5. Interaction Patterns & State Management

1. **Table Row Hover State:**
   * Transitions from `#1A262B` to `#202F36` in `150ms ease-in-out`.
   * Action icons (edit pencil) increase from `0.6` opacity to `1.0`.
2. **Expandable Variation Rows:**
   * Clicking variant badges (e.g., `Variation (4)`) triggers an accordion transition inline, revealing child rows (sizes, colors, barcode details) with indented nesting.
3. **Bulk Action Triggers:**
   * Selecting $\ge 1$ checkboxes activates sticky batch-operation controls in the top action bar.

---

## 6. Accessibility & Engineering Guidelines

* **Contrast Compliance:** White primary text (`#FFFFFF`) and mint interactive elements (`#00E599`) against dark surfaces (`#1A262B`) provide a contrast ratio $> 8:1$, exceeding **WCAG 2.1 Level AAA** requirements.
* **Keyboard Navigation:** Native tab-order across interactive elements (`checkbox` $\to$ `title link` $\to$ `quick edit button`).
* **Responsive Breakpoints:**
  * $\ge 1280\text{px}$: Full layout with expanded sidebar.
  * $1024\text{px} - 1279\text{px}$: Collapsed icon-only rail sidebar.
  * $< 1024\text{px}$: Off-canvas drawer sidebar, horizontally scrollable data grid with sticky SKU and Action columns.