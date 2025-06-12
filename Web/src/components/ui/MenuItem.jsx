const MenuItem = ({ icon: Icon, label, isActive = false, collapsed }) => {
  return (
    <li>
      <a
        href="#"
        className={`
          flex items-center px-3 py-2.5 rounded-lg transition-all duration-200
          ${
            isActive
              ? "bg-neutral-900 text-white shadow-lg"
              : "text-gray-300 hover:bg-neutral-700 hover:text-white"
          }
          ${collapsed ? "justify-center" : "justify-start"}
        `}
      >
        <Icon size={20} className="flex-shrink-0" />
        {!collapsed && <span className="ml-3 font-medium">{label}</span>}
      </a>
    </li>
  );
};

export default MenuItem;
