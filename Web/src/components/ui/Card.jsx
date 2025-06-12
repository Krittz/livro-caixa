import React from "react";

const Card = ({ title, value, change, icon: Icon, iconColor }) => {
  return (
    <div className="bg-neutral-800 rounded-xl border border-neutral-700 p-6 hover:shadow-lg transition-shadow">
      <div className="flex items-center justify-between">
        <div>
          <p className="text-sm font-medium text-neutral-400">{title}</p>
          <p className="text-3xl font-bold text-white mt-2">{value}</p>
          <p className="text-sm text-green-600 mt-1">+{change}%</p>
        </div>
        <div className="p-3 bg-neutral-900 rounded-lg">
          <Icon size={24} className={`${iconColor}`} />
        </div>
      </div>
    </div>
  );
};

export default Card;
