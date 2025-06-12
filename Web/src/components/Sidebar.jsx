import {
  Home,
  Settings,
  Users,
  BarChart3,
  X,
  ChevronLeft,
  ChevronRight,
} from "lucide-react";
import MenuItem from "./ui/MenuItem";

const Sidebar = ({ isOpen, onToggle, collapsed, onCollapse }) => {
  const menuItems = [
    { icon: Home, label: "Dashboard", isActive: true },
    { icon: BarChart3, label: "Analytics" },
    { icon: Users, label: "Users" },
    { icon: Settings, label: "Settings" },
  ];

  return (
    <>
      {/* Overlay para mobile */}
      {isOpen && (
        <div
          className="fixed inset-0 bg-neutral-900 bg-opacity-50 z-40 lg:hidden"
          onClick={onToggle}
        />
      )}

      {/* Sidebar */}
      <aside
        className={`
        fixed top-0 left-0 h-full bg-neutral-800 border-r border-neutral-700 z-50
        transition-all duration-300 ease-in-out
        ${isOpen ? "translate-x-0" : "-translate-x-full lg:translate-x-0"}
        ${collapsed ? "lg:w-16" : "lg:w-64"}
        w-64
      `}
      >
        <div className="flex flex-col h-full">
          {/* Header */}
          <div className="flex items-center justify-between p-4 border-b border-neutral-700">
            {!collapsed && (
              <div className="flex items-center">
                <div className="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                  <span className="text-neutral-900 font-bold text-xl">C</span>
                </div>
                <span className="ml-2 text-white font-semibold">CrAn</span>
              </div>
            )}

            {/* Botão de colapsar - apenas desktop */}
            {/* <button
              onClick={onCollapse}
              className="hidden lg:flex p-1.5 rounded-md text-gray-400 hover:text-white hover:bg-neutral-700 transition-colors"
            >
              {collapsed ? (
                <ChevronRight size={16} />
              ) : (
                <ChevronLeft size={16} />
              )}
            </button> */}

            {/* Botão de fechar - apenas mobile */}
            <button
              onClick={onToggle}
              className="lg:hidden p-1.5 rounded-md text-gray-400 hover:text-white hover:bg-neutral-700 transition-colors"
            >
              <X size={16} />
            </button>
          </div>

          {/* Menu */}
          <nav className="flex-1 px-3 py-4">
            <ul className="space-y-2">
              {menuItems.map((item, index) => (
                <MenuItem
                  key={index}
                  icon={item.icon}
                  label={item.label}
                  isActive={item.isActive}
                  collapsed={collapsed}
                />
              ))}
            </ul>
          </nav>

          {/* Footer */}
          <div className="p-4 border-t border-neutral-700">
            <div
              className={`flex items-center ${
                collapsed ? "justify-center" : ""
              }`}
            >
              <div className="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                <span className="text-white text-sm font-medium">U</span>
              </div>
              {!collapsed && (
                <div className="ml-3">
                  <p className="text-white text-sm font-medium">User Name</p>
                  <p className="text-gray-400 text-xs">user@email.com</p>
                </div>
              )}
            </div>
          </div>
        </div>
      </aside>
    </>
  );
};

export default Sidebar;
